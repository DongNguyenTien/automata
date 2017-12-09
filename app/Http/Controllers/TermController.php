<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Automata;
use App\Stack;
use SplStack;
use Illuminate\Session\Middleware\StartSession;

class TermController extends Controller
{
    public function index(){
        $list = new Automata();
        $list=$list->whereNull('deleted_at')->get();
        return view('Term.index',compact('list'));
    }

    public function handle(Request $request){
        $data=$request->all();
        $temp = array_diff(str_split($data['term']),[',','(',')']);
        $arrInitial =array();
        foreach($temp as $item){
            $arrInitial[]=$item;
        }
        $arrInitial=array_reverse($arrInitial);


        //Stack

        //Bien dem so stack theo thoi gian thuc
        $count=1;
        //Array Stack : has many stack; Can 1 mang cac stack
        $arr_stack = array();
        //Can 1 mang ket qua nua
        $arr_result = array();

        //transition
        $automata = Automata::where('id','=',$data['automata'])->first();
        $transition = json_decode($automata['transition'],true);
        $alphabet = json_decode($automata['alphabet'],true);

        //So luong phan tu cua mang
        $total = count($arrInitial);
        $arr_stack[0] = new Stack();


        $count_tmp= 0;

        /**
         * Cai nay dung de tinh toan cac stack giong nhau de sao chep
         */
        $total_stack_tmp=1;

        //Duyet theo mang cac chu cai trong term ban dau
        for($i=0;$i<$total;$i++){
            /**
             * Check arity của index $arrInitial đó trong alphabet, nếu không có, thì break luôn, ko chấp nhận bởi automata đó
             * Nếu có, trả về số lượng arity
             */



            if(array_key_exists($arrInitial[$i],$alphabet)){
                $arity = $alphabet[$arrInitial[$i]];

                //Search transition
                /**
                 * Nếu arity = 0 => search đơn thuần index của $arrInitial
                 * Nếu arity !=0 => foreach các stack, mỗi stack pop ra tương ứng số arity => tạo ra 1 string VD:g(q,qf)
                 * Search string đó trong tập transition, nếu có, thì push value của key == string đó trong array transition
                 */


                if($arity == 0){

                    //Neu ton tai transition
                    if(array_key_exists($arrInitial[$i],$transition)){

                        $total_stack_tmp = count($arr_stack);

//                        if(count($transition[$arrInitial[$i]])>1){
//                            for($i=0;$i<$total_stack_tmp;$i++){
//                                $count++;
//                                $tmp_stack = $arr_stack[$count-$total_stack_tmp]->stack;
//                                $arr_stack[$count] = new Stack(100,$tmp_stack);
//                            }
//                            $count=0;
//                        }

                        //Tạo ra các stack theo đủ số transition*số stack ban đầu có
                        for($r=1;$r<count($transition[$arrInitial[$i]]);$r++){
                            for($k=0;$k<$total_stack_tmp;$k++){
                                $tmp_stack = $arr_stack[$count-$total_stack_tmp]->stack;
                                $arr_stack[$count] = new Stack(100,$tmp_stack);
                                $count++;
                            }
                        }


                        $count_time=0;
                        //Foreach tung transition thoa man
                        for ($j=0;$j<count($transition[$arrInitial[$i]]);$j++) {
                            //push transition vao stack

                            for($t=0;$t<$total_stack_tmp;$t++){

                                if(isset($arr_stack[$t+($count_time*$total_stack_tmp)])){
                                    $arr_stack[$t+($count_time*$total_stack_tmp)]->push($transition[$arrInitial[$i]][$j]);
                                }
                                $count_time++;
                            }
                        }
                    }
                    else break;
                }


                else{
                    //Bien mang gom cac transition de check voi tap transition ban dau
                    $trans_check=array();


                    //Vong lap Stack

                    foreach($arr_stack as $item) {


                        $trans_tmp = $arrInitial[$i]."()";


                        for($y=0;$y<$arity;$y++){
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


                        if(!array_key_exists($trans_tmp,$transition)){
                            unset($arr_stack[array_search($item,$arr_stack)]);
                            $count--;
                        }
                        else {$trans_check[]=$trans_tmp;}



                    }


                    $countReset = 0;

                    //Reset lai mảng các stack về đúng chỉ số
                    foreach ($arr_stack as $item){
                        $arr_stack_tmp[$countReset] = $item;
                        $countReset++;
                    }
                    $arr_stack = $arr_stack_tmp;



                    //Den day van dung




                    $test=0;
                    foreach($trans_check as $tran){
                    /**
                     * Bay gio phai kiem tra trans_check roi xoa het cac stack bị lỗi đi, nếu mà tất cả lõi thì break hết
                     * tạo ra array mới chỉ gồm cái có tồn tại transition, và các stack thoả mãn cái đó, rồi làm tiếp
                     */
                        if(array_key_exists($tran,$transition)){



                            $total_stack_tmp = count($arr_stack);




//                            if(count($transition[$tran])>1){
//
//                                /**
//                                 * Dang bi sai khi 1 stack gặp lỗi transition, thì phải loại bỏ các đó ngay,
//                                 * => Xoá stack đó đi, sau đó mới check transition >
//                                 */
//
//
//                                for($u=0;$u<$total_stack_tmp;$u++){
//                                    $count++;
//
//                                    if(!empty($arr_stack[$count-$total_stack_tmp])){
//
//                                        $tmp_stack = $arr_stack[$count-$total_stack_tmp]->stack;
//                                    }
//
//
//                                    $arr_stack[$count] = new Stack(100,$tmp_stack);
//
//
//                                }
//                                $count=0;
//
//
//                            }



                            //Tạo ra các stack theo đủ số transition*số stack ban đầu có
                            for($r=1;$r<count($transition[$tran]);$r++){
                                for($k=0;$k<$total_stack_tmp;$k++){
                                    $tmp_stack = $arr_stack[$count-$total_stack_tmp]->stack;
                                    $arr_stack[$count] = new Stack(100,$tmp_stack);
                                    $count++;
                                }
                            }






                            $count_time=0;

                            //Foreach tung transition thoa man de thay doi stack
                            for ($j=0;$j<count($transition[$tran]);$j++) {

                                //push transition vao stack
                                //1 nhom stack se cung push 1 transition

                                for($t=0;$t<$total_stack_tmp;$t++){
//

                                    if(isset($arr_stack[$test+$t+($count_time*$total_stack_tmp)])){
                                        $arr_stack[$test+$t+($count_time*$total_stack_tmp)]->push($transition[$tran][$j]);
                                    }


                                    $count_time++;
                                }

                            }


                        $test++;
                        }
                        else {}
                    }




                }

                foreach ($arr_stack as $item){
                    if(count($item->stack)==0){
                        unset($arr_stack[array_search($item,$arr_stack)]);
                        $count--;
                    }
                }
                $countReset = 0;


                $arr_stack_tmp_2 =array();
                //Reset lai mảng các stack về đúng chỉ số
                foreach ($arr_stack as $item){
                    $arr_stack_tmp_2[$countReset] = $item;
                    $countReset++;
                }
                $arr_stack = $arr_stack_tmp_2;

            }


            else break;

        }
        dd($arr_stack);





    }

    public function show(){
        echo "da break";
    }



}
