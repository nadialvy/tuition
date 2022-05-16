<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Student;
use Illuminate\Support\Carbon;
use Carbon\CarbonPeriod;

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

    public function upload_photo(Request $request, $id){
        $validator = Validator::make($request->all(), 
        [
            'student_photo' => 'required|file|mimes:jpeg,png,jpg,jfif|max:2048'
        ]);

        if($validator -> fails()){
            return Response() -> json($validator -> errors());
        }

        //rename book_cover to unique name
        $student_photo_name = time().'.'.$request->student_photo->extension();

        //process upload
        $request->student_photo->move(public_path('student_images'), $student_photo_name);

        $store=DB::table('student')
                ->where('student_id', '=', $id)
                ->update([
                    'image' =>$student_photo_name
                ]);

        $data = Student::where('student_id', '=', $request->$id)-> get();
        if($store){
            return Response() -> json([
                'status' => 1,
                'message' => 'Succes upload student photo!',
                'data' => $data
            ]);
        } else 
        {
            return Response() -> json([
                'status' => 0,
                'message' => 'Failed upload student photo!'
            ]);
        }
    }
    // create data end 

    // read data start
    public function show(){
        $data = DB::table('student')
                ->select('student.*', 'grade.*', 'grade.name as grade_name', 'student.name as student_name', 'tuition.generation as tuition_generation')
                ->join('grade', 'student.grade_id', '=', 'grade.grade_id')
                ->join('tuition', 'grade.generation', '=', 'tuition.tuition_id')
                ->orderBy('student.student_id')
                ->get();
        return $data;
    } 

    public function detail($id){
        $detail = DB::table('student')
                ->where('student_id', $id)
                ->join('grade', 'student.grade_id', '=', 'grade.grade_id')
                ->join('tuition', 'grade.generation', '=', 'tuition.tuition_id')
                ->select('student.name', 'tuition.nominal')
                ->first();

        return Response()->json([$detail]);
    }

    public function detail_bill($id){
        //get bill data
        $bill = DB::table('student')
                ->where('student_id', $id)
                ->join('grade', 'student.grade_id', '=', 'grade.grade_id')
                ->join('tuition', 'grade.generation', '=', 'tuition.tuition_id')
                ->select('student.bill', 'tuition.start_payment', 'tuition.nominal')
                ->first();

        //loop month
        $from = $bill->start_payment;
        $to = Carbon::now();
        $period = CarbonPeriod::create($from, '1 month', $to);
        
        //get nominal tuition per month
        $student_nominal = $bill->nominal;

        //push the month and tuition to array
        $billBeforePayment = [];
        foreach ($period as $dt) {
            array_push($billBeforePayment,(object) [
                        "date" => $dt->format("F Y"),
                        "nominal" => $student_nominal
            ]);
        }

        //check if student is already pay or not
        $dataPayment = DB::table('payment')
                        ->where('student_id', $id)
                        ->get();

        $total = count($dataPayment);

        $billAfterPayment = array_splice($billBeforePayment, $total);

        return Response()->json($billAfterPayment);
    }

    //only shows students who still have tuition dependents
    public function student_with_tuition(){
        //jika didalam data history payment bagian tuition for match dengan bulan ini maka student tidak usah ditampilkan
        // $dataHistoryPayment = 
        $data = app('App\Http\Controllers\PaymentController')->history_payment();
        return $data;
    }
    

    //read data end

    // update data start
    public function update($id, Request $req){
        $validator = Validator::make( $req->all(),[
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

        $update = DB::table('student')
                    ->where('student_id', $id)
                    ->update([
                        'nisn' => $req->nisn,
                        'nis' => $req->nis,
                        'name' => $req->name,
                        'grade_id' => $req->grade_id,
                        'address' => $req->address,
                        'phone' => $req->phone,
                    ]);
        
        $data = Student::where('student_id', '=', $id)->get();
        if($update){
            return Response()->json([
                'status' => 1,
                'message' => 'Success update data',
                'data' => $data
            ]);
        } else {
            return Response()->json([
                'status' => 0,
                'message' => 'Failed to update data'
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
