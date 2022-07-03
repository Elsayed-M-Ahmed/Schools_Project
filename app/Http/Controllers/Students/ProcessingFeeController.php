<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\ProcessingFee;
use App\Models\StudentsAccounts;
use Illuminate\Support\Facades\DB;

class ProcessingFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ProcessingFees = ProcessingFee::all();
        return view('pages.ProcessingFee.index',compact('ProcessingFees'));
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

            // اضافه فى جدول معالجه الرسوم
            $ProcessingFee = new ProcessingFee();
            $ProcessingFee->date = date('Y-m-d');
            $ProcessingFee->student_id = $request->student_id;
            $ProcessingFee->amount = $request->Credit;
            $ProcessingFee->description = $request->description;
            $ProcessingFee->save();

            //اضافه فى جدول حسابات الطالب
            $students_accounts = new StudentsAccounts();
            $students_accounts->date = date('Y-m-d');
            $students_accounts->type = 'processing fee';
            $students_accounts->student_id = $request->student_id;
            $students_accounts->processing_id = $ProcessingFee->id;
            $students_accounts->Debit = 0.00;
            $students_accounts->Credit = $request->Credit;
            $students_accounts->description = $request->description;
            $students_accounts->save();

            DB::commit();
            toastr()->success(trans('message.success'));
            return redirect()->route('ProcessingFee.index');
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
        $student = Student::findOrfail($id);
        return view('pages.ProcessingFee.add', [ 
            'student' => $student,
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
        $ProcessingFee = ProcessingFee::findOrFail($id);
        return view('pages.ProcessingFee.edit',[
            'ProcessingFee' => $ProcessingFee,
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
        // return $request;

        
        DB::beginTransaction();
        try {

            // تعديل البيانات في جدول معالجة الرسوم
            $ProcessingFee = ProcessingFee::findorfail($request->id);;
            $ProcessingFee->date = date('Y-m-d');
            $ProcessingFee->student_id = $request->student_id;
            $ProcessingFee->amount = $request->Credit;
            $ProcessingFee->description = $request->description;
            $ProcessingFee->save();

            // تعديل البيانات في جدول حساب الطلاب
            $students_accounts = StudentsAccounts::where('processing_id',$request->id)->first();;
            $students_accounts->date = date('Y-m-d');
            $students_accounts->type = 'ProcessingFee';
            $students_accounts->student_id = $request->student_id;
            $students_accounts->processing_id = $ProcessingFee->id;
            $students_accounts->Debit = 0.00;
            $students_accounts->credit = $request->Credit;
            $students_accounts->description = $request->description;
            $students_accounts->save();

            DB::commit();
            toastr()->success(trans('message.success'));
            return redirect()->route('ProcessingFee.index');
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
            ProcessingFee::destroy($request->id);
            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
        }

        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
