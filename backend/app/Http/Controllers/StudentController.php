<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Student;
use Illuminate\Support\Carbon;

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
            'phone' => 'required|max:13',
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $getData = DB::table('grade')
                        ->select('tuition.*')
                        ->where('grade_id', $req->grade_id)
                        ->join('tuition', 'grade.generation', '=', 'tuition.tuition_id')
                        ->first();

        $getStartPay = $getData->start_payment;
        $totalMonths = Carbon::now()->diffInMonths(Carbon::parse($getStartPay)) +1;

        $getNominal = $getData->nominal;
        $getBill = $getNominal * $totalMonths;
        // var_dump($getBill);

        $store = Student::create([
            'nisn' => $req->nisn,
            'nis' => $req->nis,
            'name' => $req->name,
            'grade_id' => $req->grade_id,
            'address' => $req->address,
            'phone' => $req->phone,
            'bill' => $getBill,
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

    // read data start
    public function show(){
        return Student::all();
    } 

    public function detail($nisn){
        // $getData = DB::table('student')
        //                 ->select('tuition.nominal', 'tuition.start_payment')
        //                 ->where('nisn', $nisn)
        //                 ->join('grade', 'student.grade_id', '=', 'grade.grade_id')
        //                 ->join('tuition', 'grade.generation', '=', 'tuition.tuition_id')
        //                 ->first();

        // $getStartPay = $getData->start_payment;
        // $totalMonths = Carbon::now()->diffInMonths(Carbon::parse($getStartPay)) +1;

        // $getNominal = $getData->nominal;
        // $getBill = $getNominal * $totalMonths;

        // return $getData;
    }
    // read data end 

    // update data start
    public function update($id, Request $req){
        $validator = Validator::make( $req->all(), 
        [
            'nisn' => 'required|max:10|string',
            'nis' => 'required|max:8|string',
            'name' => 'required|max:35|string',
            'grade_id' => 'required',
            'address' => 'required',
            'phone' => 'required|max:13',
            'bill' => 'required|int',
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $update = Student::where('student_id', $id)->update([
            'nisn' => $req->nisn,
            'nis' => $req->nis,
            'name' => $req->name,
            'grade_id' => $req->grade_id,
            'address' => $req->address,
            'phone' => $req->phone,
            'bill' => $req->bill,
        ]);

        $data = Student::where('student_id', $id)->first();
        if($update){
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully update data',
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
        $delete = Student::where('student_id', $id)->delete();

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
