<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Grade;

class GradeController extends Controller
{
    // create data start
    public function store(Request $req){
        $validator = Validator::make( $req->all(), 
        [
            'name' => 'required|string|max:10',
            'major' => 'required|string|max:5',
            'generation' => 'required',
        ]);

        if($validator -> fails()){
            return response()->json($validator->errors());
        }

        $store = Grade::create([
            'name' => $req->name,
            'major' => $req->major,
            'generation' => $req->generation,
        ]);

        $data = Grade::where('name', $req->name)->first();  
        if($store){
            return response()->json([
                'status' => 'success',
                'data' => $data,
            ]);
        }else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create data',
            ]);
        }
    } 
    // create data end 
}
