<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Tuition;

class TuitionController extends Controller
{
    // create data start
    public function store(Request $req){
        $validator = Validator::make( $req->all(), 
        [
            'generation' => 'required',
            'year' => 'required',
            'nominal' => 'required'
        ]);

        if($validator -> fails()){
            return response()->json($validator->errors());
        }

        $store = Tuition::create([
            'generation' => $req->generation,
            'year' => $req->year,
            'nominal' => $req->nominal
        ]);
        
        $data = Tuition::where('generation', $req->generation)->first();
        if($store){
            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        }else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to store data'
            ]);
        }
    } 
    // create data end 

    // read data start 
    public function show(){
        return Tuition::all();
    }

    public function detail($id){
        return Tuition::where('tuition_id', $id)->first();
    }
    // read data end 

}
