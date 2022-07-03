<?php

namespace App\Http\Controllers\Subjects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Teacher;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::all();
        return view('pages.subjects.index' , [
            'subjects' => $subjects ,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grades = Grade::all();
        $teachers = Teacher::all();
        return view('pages.subjects.create' , [
            'grades' => $grades ,
            'teachers' => $teachers ,
        ]);
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

        try {
            Subject::create([
                'name' => ['en' => $request->Name_en , 'ar' => $request->Name_ar] ,
                'grade_id' => $request->Grade_id ,
                'classroom_id' => $request->Class_id ,
                'teacher_id' => $request->teacher_id,
            ]);

            toastr()->success(trans('message.success'));
            return redirect()->route('subjects.index');
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
        $subject = Subject::findOrFail($id);
        $grades = Grade::all();
        $teachers = Teacher::all();
        return  view('pages.subjects.edit' , [
            'subject' => $subject ,
            'grades' => $grades ,
            'teachers' => $teachers ,
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

        try {
            Subject::where('id' , '=' , $request->id)->update([
                'name' => ['en' => $request->Name_en , 'ar' => $request->Name_ar] ,
                'grade_id' => $request->Grade_id ,
                'classroom_id' => $request->Class_id ,
                'teacher_id' => $request->teacher_id,
            ]);

            toastr()->success(trans('message.success'));
            return redirect()->route('subjects.index');
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
        // return $request;

        try {
            Subject::where('id' , '=' ,$request->id)->delete();

            toastr()->error(trans('message.success'));
            return redirect()->route('subjects.index');
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
