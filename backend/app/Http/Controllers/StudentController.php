<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Student;

class StudentController extends Controller
{
    // create data start
    public function store(Request $req){
        $validator = Validator::make( $req->all(), 
        [
            'nisn' => 'required|max:10|string',
            'nis' => 'required|max:8|string',
            'name' => 'required|max:35|string',
            'grade_id' => 'required',
            'address' => 'required',
            'phone' => 'required|max:13'
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $store = Student::create([
            'nisn' => $req->nisn,
            'nis' => $req->nis,
            'name' => $req->name,
            'grade_id' => $req->grade_id,
            'address' => $req->address,
            'phone' => $req->phone
        ]);

        $data = Student::where('nisn', $req->nisn)->first();
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
