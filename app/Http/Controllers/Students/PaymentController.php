<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentStudent;
use App\Models\Student;
use App\Models\FundAccount;
use App\Models\StudentsAccounts;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payment_students = PaymentStudent::all();
        return view('pages.Payment.index' , [
            'payment_students' => $payment_students
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;

        DB::beginTransaction();
        try {
            // حفظ البيانات في جدول سندات الصرف
            $payment_students = new PaymentStudent();
            $payment_students->date = date('Y-m-d');
            $payment_students->amount = $request->Debit;
            $payment_students->description = $request->description;
            $payment_students->student_id = $request->student_id;
            $payment_students->save();

            // حفظ البيانات في جدول الصندوق
            $fund_accounts = new FundAccount();
            $fund_accounts->date = date('Y-m-d');
            $fund_accounts->payment_id = $payment_students->id;
            $fund_accounts->Debit = 0.00;
            $fund_accounts->credit = $request->Debit;
            $fund_accounts->description = $request->description;
            $fund_accounts->save();

            // حفظ البيانات في جدول حساب الطلاب
            $students_accounts = new StudentsAccounts();
            $students_accounts->date = date('Y-m-d');
            $students_accounts->type = 'payment';
            $students_accounts->student_id = $request->student_id;
            $students_accounts->payment_id = $payment_students->id;
            $students_accounts->Debit = $request->Debit;
            $students_accounts->credit = 0.00;
            $students_accounts->description = $request->description;
            $students_accounts->save();

            DB::commit();
            toastr()->success(trans('message.success'));
            return redirect()->route('Payment_students.index');
        } catch (\Exception $e) {
            DB::rollback();
           return redirect()->back()->withErrors(['error' => $e->getMessage()]);
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = Student::findOrFail($id);
        return view('pages.Payment.add' , [
            'student' => $student
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment_student = PaymentStudent::findOrFail($id);
        return view('pages.Payment.edit' , [
            'payment_student' => $payment_student
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //return $request;

        DB::beginTransaction();
        try {
            // حفظ البيانات في جدول سندات الصرف
            $payment_students = PaymentStudent::findOrFail($request->id);
            $payment_students->date = date('Y-m-d');
            $payment_students->amount = $request->Debit;
            $payment_students->description = $request->description;
            $payment_students->student_id = $request->student_id;
            $payment_students->save();

            // حفظ البيانات في جدول الصندوق
            $fund_accounts = FundAccount::where('payment_id' , $request->id)->first();
            $fund_accounts->date = date('Y-m-d');
            $fund_accounts->payment_id = $payment_students->id;
            $fund_accounts->Debit = 0.00;
            $fund_accounts->credit = $request->Debit;
            $fund_accounts->description = $request->description;
            $fund_accounts->save();

            // حفظ البيانات في جدول حساب الطلاب
            $students_accounts = StudentsAccounts::where('payment_id' , $request->id)->first();
            $students_accounts->date = date('Y-m-d');
            $students_accounts->type = 'payment';
            $students_accounts->student_id = $request->student_id;
            $students_accounts->payment_id = $payment_students->id;
            $students_accounts->Debit = $request->Debit;
            $students_accounts->credit = 0.00;
            $students_accounts->description = $request->description;
            $students_accounts->save();

            DB::commit();
            toastr()->success(trans('message.success'));
            return redirect()->route('Payment_students.index');
        } catch (\Exception $e) {
            DB::rollback();
           return redirect()->back()->withErrors(['error' => $e->getMessage()]);
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            PaymentStudent::destroy($request->id);
            toastr()->error(trans('message.Delete'));
            return redirect()->back();
        }

        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
