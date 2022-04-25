<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use App\Models\Payment;

class PaymentController extends Controller
{
    // create data start
    public function store(Request $req){
        $validator = Validator::make($req->all(), 
        [
            'officer_id' => 'required',
            'student_id' => 'required',
            // 'payment_date' => 'required',
            'tuition_month' => 'required|int',
            'tuition_year' => 'required|int',
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $store = Payment::create([
            'officer_id' => $req->officer_id,
            'student_id' => $req->student_id,
            'payment_date' => Carbon::now(),
            'tuition_month' => $req->tuition_month,
            'tuition_year' => $req->tuition_year,
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
        ->select('payment.*', 'officer.username', 'student.name')
        ->get();

        return Response()->json([
            'data' => $data,
        ]);
    }
    // read data end 
}
