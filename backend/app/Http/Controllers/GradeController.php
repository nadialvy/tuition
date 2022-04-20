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
            'major' => 'required|string|max:10',
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

    // read data start
    public function show(){
        $data = DB::table('grade')
        ->join('tuition', 'grade.generation', '=', 'tuition.tuition_id')
        ->select('grade.*', 'tuition.generation')
        ->get();

        return Response()->json([
            'data' => $data,
        ]);
    } 
    // read data end

    // update data start 
    public function update($id, Request $req){
        $validator = Validator::make( $req->all(), 
        [
            'name' => 'required|string|max:10',
            'major' => 'required|string|max:10',
            'generation' => 'required',
        ]);

        if($validator -> fails()){
            return response()->json($validator->errors());
        }

        $update = Grade::where('grade_id', $id)->update([
            'name' => $req->name,
            'major' => $req->major,
            'generation' => $req->generation,
        ]);

        $data = Grade::where('name', $req->name)->first();
        if($update){
            return response()->json([
                'status' => 'success',
                'data' => $data,
            ]);
        }else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update data',
            ]);
        }
    }
    // update data end 

    // delete data start
    public function delete($id){
        $delete = Grade::where('grade_id', $id)->delete();

        if($delete){
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully deleted data',
            ]);
        }else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete data',
            ]);
        }
    } 
    // delete data end 
}
