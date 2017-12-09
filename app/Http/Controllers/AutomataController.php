<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mockery\Exception;
use Yajra\Datatables\Datatables;
use App\Automata;

class AutomataController extends Controller
{
    public function index(){
        return view('Automata.index');
    }

    public function create(){
        return view('automata.create');
    }

    public function store(Request $request){
        try{
            $data = $request->all();
            $alphabet = array() ;
            foreach(explode(',',$data['alphabet']) as $item){
                $alphabet[strtok($item,':')]=substr($item,strlen(strtok($item,':'))+1);
            }
            $data['alphabet']=json_encode($alphabet);
            $data['transition']=explode(';',$data['transition']);
            $temp = array();
            for($i=0;$i<count($data['transition']);$i++){
                $handle = strtok($data['transition'][$i],'->');
                $temp[$handle][]=substr($data['transition'][$i],strlen($handle)+2);
            }
            $data['transition']=json_encode($temp);
            Automata::create($data);

            return redirect()->route('automata_index');
        }catch(Exception $exception){
            return redirect()->back()->withInput();
        }

    }


    public function getList(Datatables $datatables){
        $list = new Automata();
        return $datatables->of($list->select('*')->whereNull('deleted_at'))
            ->escapeColumns([])
            ->make(true);
    }
}
