<?php

namespace App\Http\Controllers\Exams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exams = Exam::all();
        return view('pages.Exams.index' , [
            'exams' => $exams ,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.Exams.create');
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

        try{
        Exam::create([
            'name' => ['en' => $request->Name_en , 'ar' => $request->Name_ar],
            'term' => $request->term ,
            'academic_year' => $request->academic_year ,
        ]);

        toastr()->success(trans('message.success'));
            return redirect()->route('Exams.index');
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $exam = Exam::findOrFail($id);
        return view('pages.Exams.edit' , [
            'exam' => $exam ,
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

        try{
            Exam::where('id' , '=' , $request->id)->update([
                'name' => ['en' => $request->Name_en , 'ar' => $request->Name_ar],
                'term' => $request->term ,
                'academic_year' => $request->academic_year ,
            ]);
    
            toastr()->success(trans('message.success'));
                return redirect()->route('Exams.index');
            } catch (Exception $e) {
                return redirect()->back()->with(['error' => $e->getMessage()]);
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
            Exam::where('id' , '=' ,$request->id)->delete();

            toastr()->error(trans('message.success'));
            return redirect()->route('Exams.index');
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
