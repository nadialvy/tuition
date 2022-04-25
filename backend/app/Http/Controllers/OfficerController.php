<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Models\Officer;

class OfficerController extends Controller
{
    // create data start
    public function store(Request $req){
        $validator = Validator::make( $req->all(), 
        [
            'username' => 'required|string|max:25',
            'password' => 'required|string|max:255',
            'officer_name' => 'required|string|max:35',
            'level' => 'required|string'
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $store = Officer::create([
            'username' => $req->username,
            'password' => $req->password,
            'officer_name' => $req->officer_name,
            'level' => $req->level
        ]);

        $data = Officer::where('username', $req->username)->first();
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
        return Officer::all();
    } 
    // read data end 

    // update data start
    public function update($id, Request $req){
        $validator = Validator::make($req->all(), 
        [
            'username' => 'required|string|max:25',
            'password' => 'required|string|max:255',
            'officer_name' => 'required|string|max:35',
            'level' => 'required|string'
        ]);
        
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $update = Officer::where('officer_id', $id)->update([
            'username' => $req->username,
            'password' => $req->password,
            'officer_name' => $req->officer_name,
            'level' => $req->level
        ]);

        $data = Officer::where('officer_id', $id)->first();
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
        $delete = Officer::where('officer_id', $id)->delete();

        if($delete){
            return response()->json([
                'status' => 'success',
                'message' => 'Data has been deleted'
            ]);
        }else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete data'
            ]);
        }
    }
    // delete data end 
}
