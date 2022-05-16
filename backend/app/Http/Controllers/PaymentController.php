<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Carbon\CarbonPeriod;
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
                ->orderBy('payment_id')
                ->get();

        return Response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    //get data payment by student id
    public function history_payment($id){
        $data = DB::table('payment')
                ->join('student', 'payment.student_id', '=', 'student.student_id')
                ->join('grade', 'student.grade_id', '=', 'grade.grade_id')
                ->join('tuition', 'grade.generation', '=', 'tuition.tuition_id')
                ->select('payment.payment_date', 'tuition.start_payment', 'tuition.nominal')
                ->where('payment.student_id', $id)
                ->get();

        if($data->count() > 0){
            //loop month
            $from = $data[0]->start_payment;
    
            //check if student is already pay or not
            $dataPayment = DB::table('payment')
                            ->where('student_id', $id)
                            ->get();
            $total = count($dataPayment) - 1;

            $to = date('Y-m-d', strtotime($from. ' + '. $total .' months')); //to harusnya start payment + berapa kali dia bayar
            // var_dump($to);
    
            $period = CarbonPeriod::create($from, '1 month', $to);
    
            $dataDetail = [];
            foreach ($period as $dt) {
                array_push($dataDetail,(object) [
                            "payment_date" => $data[0] -> payment_date,  
                            "tuition_date" => $dt->format("F Y"),
                            "nominal" =>$data[0]->nominal,
                ]);
            }
    
            return Response()->json([
                'status' => 'success',
                'data' => $dataDetail,
            ]);
        }else {
            return Response()->json([
                'status' => 'error',
                'message' => 'Student never paid the tuition',
            ]);
        }

        
    }
    // read data end 
}
