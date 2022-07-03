<?php

namespace App\Http\Controllers\Fees;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fees;
use App\Models\FeeInvoices;
use App\Models\Grade;
use App\Models\Student;
use App\Models\StudentsAccounts;
use Illuminate\Support\Facades\DB;

class FeeInvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Fee_invoices = FeeInvoices::all();
        $Grades = Grade::all();
        return view('pages.Fees_Invoices.index',compact('Fee_invoices','Grades'));
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
        // return $request;

        $List_Fees = $request->List_Fees;

        DB::beginTransaction();

        try {
            foreach ($List_Fees as $List_Fee) {
                $Fees = new FeeInvoices();
                $Fees->invoice_date = date('Y-m-d');
                $Fees->student_id = $List_Fee['student_id'];
                $Fees->Grade_id = $request->Grade_id;
                $Fees->Classroom_id = $request->Classroom_id;;
                $Fees->fee_id = $List_Fee['fee_id'];
                $Fees->amount = $List_Fee['amount'];
                $Fees->description = $List_Fee['description'];
                $Fees->save();

                // حفظ البيانات في جدول حسابات الطلاب
                $StudentAccount = new StudentsAccounts();
                $StudentAccount->date = date('Y-m-d');
                $StudentAccount->type = 'invoice';
                $StudentAccount->fee_invoice_id = $Fees->id;
                $StudentAccount->student_id = $List_Fee['student_id'];
                $StudentAccount->Debit = $List_Fee['amount'];
                $StudentAccount->credit = 0.00;
                $StudentAccount->description = $List_Fee['description'];
                $StudentAccount->save();
                // // حفظ البيانات في جدول فواتير الرسوم الدراسية
                // FeeInvoices::create([
                //     'invoice_date' => date('Y-m-d'),
                //     'amount' => $List_Fee['amount'],
                //     'description' => $List_Fee['description'],
                //     'student_id' => $List_Fee['student_id'],
                //     'Grade_id' => $request->Grade_id,
                //     'Classroom_id' => $request->Classroom_id,
                //     'fee_id' => $List_Fee['fee_id'],
                // ]);

                // // حفظ البيانات في جدول حسابات الطلاب
                // StudentsAccounts::create([
                //     'date' => date('Y-m-d'),
                //     'type' => 'invoice',
                //     'Debit' => $List_Fee['amount'],
                //     'credit' => 00.00 ,
                //     'description' => $List_Fee['description'],
                //     'student_id' => $List_Fee['student_id'],
                //     'Grade_id' => $request->Grade_id,
                //     'Classroom_id' => $request->Classroom_id,
                //     'fee_invoice_id' => $List_Fee['id'],
                // ]);    
            }

            DB::commit(); 
            toastr()->success(trans('message.success'));
                return redirect()->route('Fees_Invoices.index');
                   
        }catch (\Exception $e) {
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
        $fees = Fees::where('Classroom_id' , $student->Classroom_id)->where('Grade_id' , $student->Grade_id)->get();
        return view('pages.Fees_Invoices.add',compact('student','fees'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fee_invoices = FeeInvoices::findOrFail($id);
        $fees = Fees::where('Classroom_id',$fee_invoices->Classroom_id)->get();
        return view('pages.Fees_Invoices.edit',compact('fee_invoices','fees'));
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
        // return $request;

        DB::beginTransaction();
        try {
            // تعديل البيانات في جدول فواتير الرسوم الدراسية
            $Fees = FeeInvoices::findorfail($request->id);
            $Fees->fee_id = $request->fee_id;
            $Fees->amount = $request->amount;
            $Fees->description = $request->description;
            $Fees->save();

            // تعديل البيانات في جدول حسابات الطلاب
            $StudentAccount = StudentsAccounts::where('fee_invoice_id',$request->id)->first();
            $StudentAccount->Debit = $request->amount;
            $StudentAccount->description = $request->description;
            $StudentAccount->save();
            DB::commit();

            toastr()->success(trans('message.Update'));
            return redirect()->route('Fees_Invoices.index');
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
            FeeInvoices::destroy($request->id);
            toastr()->error(trans('message.Delete'));
            return redirect()->back();
        }

        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
