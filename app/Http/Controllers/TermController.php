<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Automata;
use App\Stack;

class TermController extends Controller
{
    public function index(){
        $list = new Automata();
        $list=$list->whereNull('deleted_at')->get();
        return view('Term.index',compact('list'));
    }

    public function handle(Request $request){

        $data=$request->all();
        $temp = array_diff(str_split($data['term']),[',','(',')',' ']);
        $arrInitial =array();
        foreach($temp as $item){
            $arrInitial[]=$item;
        }

        //Mảng lưu các giá trị đảo ngược của term đầu vào
        $arrInitial=array_reverse($arrInitial);

        //So luong phan tu cua mang
        $total = count($arrInitial);


        /**
         * Các biến liên quan đến STACK
         */

        //Bien dem so stack theo thoi gian thuc
        $count=1;

        //Mảng các stack
        $arr_stack = array();
        $arr_stack[0] = new Stack();




        /**
         * Các biến liên quan để cây automata: gồm transition và bảng chữ cái và các trạng thái
         */

        $automata = Automata::where('id','=',$data['automata'])->first();
        $transition = json_decode($automata['transition'],true);
        $alphabet = json_decode($automata['alphabet'],true);


        //Mảng chứa kết quả cuối cùng để hiện thị giao diện
        $arr_result = array();
        $arr_result[0] = array();

        /**
         * Bien ket qua cuoi cung
         */
        $final_result = array();
        //Bien nay de tao ra Exception
        $result_flag = "0";


        //Duyet theo mang cac chu cai trong term ban dau
        for($i=0;$i<$total;$i++){

            /**
             * Buoc 1:
             * Check arity của index $arrInitial đó trong alphabet, nếu không có, thì break luôn, ko chấp nhận bởi automata đó
             * Nếu có, trả về số lượng arity
             */


            if(array_key_exists($arrInitial[$i],$alphabet)){
                $arity = $alphabet[$arrInitial[$i]];

                //Search transition
                /**
                 * Buoc 2:
                 * Nếu arity = 0 => search đơn thuần index của $arrInitial
                 * Nếu arity !=0 => foreach các stack, mỗi stack pop ra tương ứng số arity => tạo ra 1 string VD:g(q,qf)
                 */


                if($arity == 0){

                    //Neu ton tai transition
                    if(array_key_exists($arrInitial[$i],$transition)){

                        $total_stack_tmp = count($arr_stack);

                        //Tạo ra các stack theo đủ số transition*số stack ban đầu có
                        for($r=1;$r<count($transition[$arrInitial[$i]]);$r++){
                            for($k=0;$k<$total_stack_tmp;$k++){
                                //Tao stack item
                                $tmp_stack = $arr_stack[$count-$total_stack_tmp]->stack;
                                $arr_stack[$count] = new Stack(100,$tmp_stack);

                                //Tao result item
                                $arr_result[$count] = array();
                                $arr_result[$count] = $arr_result[$count-$total_stack_tmp];

                                $count++;
                            }
                        }


                        $count_time=0;
                        //Foreach tung transition thoa man
                        for ($j=0;$j<count($transition[$arrInitial[$i]]);$j++) {
                            //push transition vao stack

                            for($t=0;$t<$total_stack_tmp;$t++){

                                if(isset($arr_stack[$t+($count_time*$total_stack_tmp)])){
                                    //push vao Stack
                                    $arr_stack[$t+($count_time*$total_stack_tmp)]->push($transition[$arrInitial[$i]][$j]);

                                    //Day vao mang result item
                                    array_push($arr_result[$t+($count_time*$total_stack_tmp)],$transition[$arrInitial[$i]][$j]);
                                }
                                $count_time++;
                            }
                        }
                    }

                    //Khong thi break, tra ve false
                    else {
                        $result_flag="Term không được chấp nhận bởi cây automata này do không thoả mãn transition chứa alphabet: ".$arrInitial[$i];
                        break;
                    }
                }


                else{

                    //Vong lap Stack POP

                    foreach($arr_stack as $item) {

                        //String cua transition lay ra tu Stack nay
                        $trans_tmp = $arrInitial[$i]."()";

                        //PoP stack de tao ra $trans_tmp
                        for($y=0;$y<$arity;$y++){
                            if(count($item->stack)!=0){
                                if(($y==$arity-1)&&($arity==1)){
                                    $trans_tmp=substr_replace($trans_tmp,$item->pop().')',strlen(strtok($trans_tmp,'('))+1);
                                }
                                elseif($y==$arity-1){
                                    $trans_tmp=substr_replace($trans_tmp,$item->pop().')',strlen(strtok($trans_tmp,','))+1);
                                }
                                elseif($y==0){
                                    $trans_tmp=substr_replace($trans_tmp,$item->pop().",)",strlen(strtok($trans_tmp,'('))+1);
                                }
                                else{
                                    $trans_tmp=substr_replace($trans_tmp,$item->pop().",)",strlen(strtok($trans_tmp,','))+1);
                                }
                            }
                            else {
                                $result_flag="Term không được chấp nhận bởi cây automata này do sai cấu trúc arity của chữ cái \"".$arrInitial[$i]."\" đối với alphabet của cây automata này ";
                                break 2;
                            }

                        }

                        /**
                         * Neu khong ton tai transition tao ra tu bang nay thi xoa luon stack nay khoi mang
                         */
                        if(!array_key_exists($trans_tmp,$transition)){
                            //Xoa phan tu khoi mang cac stack
                            unset($arr_stack[array_search($item,$arr_stack)]);

                            //Xoa phan tu khoi mang cac ket qua
                            unset($arr_result[array_search($item,$arr_stack)]);
                            $count--;

                        }


                        //Co ton tai transition nay
                        else {

                            //Mảng lưu các giá trị index của stack cần púsh vào
                            $index_arr_stack = array();
                            $index_arr_stack[]=array_search($item,$arr_stack);

                            //Tạo ra các stack == so transition
                            for($r=1;$r<count($transition[$trans_tmp]);$r++){
                                //Them stack
                                $tmp_stack = $arr_stack[$index_arr_stack[0]]->stack; //Cac stack them co gia tri bang stack tai index = $index_arr_stack[0]
                                $arr_stack[$count] = new Stack(100,$tmp_stack);

                                //Them result
                                $arr_result[$count] = array();
                                $arr_result[$count] = $arr_result[$index_arr_stack[0]];


                                $index_arr_stack[]=$count;
                                $count++;
                            }

                            //Push vao cac stack : ban dau va nhung cai moi tao ra
                            $index_count=0;
                            //Foreach tung transition thoa man de thay doi stack
                            for ($j=0;$j<count($transition[$trans_tmp]);$j++) {
                                //Push vao stack
                                $arr_stack[$index_arr_stack[$index_count]]->push($transition[$trans_tmp][$j]);

                                //Push vao result
                                array_push($arr_result[$index_arr_stack[$index_count]],$transition[$trans_tmp][$j]);


                                $index_count++;
                            }


                        }

                    }


                    //Reset lai mảng các stack về đúng chỉ số
                    $countReset = 0;
                    foreach ($arr_stack as $item){
                        $arr_stack_tmp[$countReset] = $item;
                        $countReset++;
                    }
                    $arr_stack = $arr_stack_tmp;

                    //Reset result ve dung chi so
                    $countReset = 0;
                    foreach ($arr_result as $item){
                        $arr_result_tmp[$countReset] = $item;
                        $countReset++;
                    }
                    $arr_result = $arr_result_tmp;



                    /**
                     * Code phan nay khong can den
                     */
                    //                    $test=0;
//                    foreach($trans_check as $tran){
//
//                        if(array_key_exists($tran,$transition)){
//
//                            $total_stack_tmp = count($arr_stack);
//
//                            //Tạo ra các stack theo đủ số transition*số stack ban đầu có
//                            for($r=1;$r<count($transition[$tran]);$r++){
//                                for($k=0;$k<$total_stack_tmp;$k++){
//                                    $tmp_stack = $arr_stack[$count-$total_stack_tmp]->stack;
//                                    $arr_stack[$count] = new Stack(100,$tmp_stack);
//                                    $count++;
//                                }
//                            }
//
//
//
//
//                            $count_time=0;
//
//                            //Foreach tung transition thoa man de thay doi stack
//                            for ($j=0;$j<count($transition[$tran]);$j++) {
//
//                                //push transition vao stack
//                                //1 nhom stack se cung push 1 transition
//
//                                for($t=0;$t<$total_stack_tmp;$t++){
////
//
//                                    if(isset($arr_stack[$test+$t+($count_time*$total_stack_tmp)])){
//                                        $arr_stack[$test+$t+($count_time*$total_stack_tmp)]->push($transition[$tran][$j]);
//                                    }
//
//
//                                    $count_time++;
//                                }
//
//                            }
//
//
//
//
//                            $test++;
//                        }
//
//                        else {}
//                    }
                    /**
                     *
                     */

                }

                /**
                 * Code phan nay khong can den
                 */

                //                //Xoa nhung Stack rong
//                foreach ($arr_stack as $item){
//                    if(count($item->stack)==0){
//                        unset($arr_stack[array_search($item,$arr_stack)]);
//                        $count--;
//                    }
//                }
//                $countReset = 0;
//
//
//                $arr_stack_tmp_2 =array();
//                //Reset lai mảng các stack về đúng chỉ số
//                foreach ($arr_stack as $item){
//                    $arr_stack_tmp_2[$countReset] = $item;
//                    $countReset++;
//                }
//                $arr_stack = $arr_stack_tmp_2;
                /**
                 *
                 */
            }

            //Khong ton tai trong bang chu cai, break
            else {
                $result_flag="Chữ cái \"".$arrInitial[$i]."\" không tồn tại trong alphabet của cây automata này";
                break;
            }

        }

        if($result_flag=="0"){
            dd($arr_stack,$arr_result);
        }
        else{
            dd($result_flag);
        }







    }

    public function show(){
        echo "da break";
    }



}
