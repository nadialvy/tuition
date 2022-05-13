<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use App\Models\Student;
use App\Models\Payment;

class PaymentController extends Controller
{
    // create data start
    public function store(Request $req){
        $validator = Validator::make($req->all(), 
        [
            'officer_id' => 'required',
            'student_id' => 'required',
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        //update bill on student
        $nominalTuition = DB::table('student')
                        ->select('tuition.nominal', 'student.bill')
                        ->where('student_id', $req->student_id)
                        ->join('grade', 'student.grade_id', '=', 'grade.grade_id')
                        ->join('tuition', 'grade.generation', '=', 'tuition.tuition_id')
                        ->first();

        $nominal = $nominalTuition->nominal;
        $bill = $nominalTuition->bill;
        $updatedBill = $bill - $nominal;

        Student::where('student_id', $req->student_id)->update([
            'bill' => $updatedBill,
        ]);

        //store data
        $store = Payment::create([
            'officer_id' => $req->officer_id,
            'student_id' => $req->student_id,
            'payment_date' => Carbon::now(),
        ]);

        $data = Payment::where('student_id', $req->student_id)->first();
        if($store){
            return Response()->json([
                'status' => 'success',
                'data' => $data,
            ]);
        }else {
            return Response()->json([
                'status' => 'error',
                'message' => 'Failed to create data',
            ]);
        }
    } 
    // create data end 

    // read data start
    public function show(){
        $data = DB::table('payment')
                ->join('officer', 'payment.officer_id', '=', 'officer.officer_id')
                ->join('student', 'payment.student_id', '=', 'student.student_id')
                ->join('grade', 'student.grade_id', '=', 'grade.grade_id')
                ->join('tuition', 'grade.generation', '=', 'tuition.tuition_id')
                ->select('payment.*', 'officer.username as officer_name', 'student.name as student_name', 'tuition.nominal')
                ->get();

        return Response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }
    // read data end 
}
