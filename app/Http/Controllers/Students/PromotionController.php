<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Student;
use App\Models\promotion;
use Illuminate\Support\Facades\DB;


class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Grades = Grade::all();
        return view('pages.Students.promotion.index' , [
            'Grades' => $Grades, 
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $promotions = Promotion::all();
        return view('pages.Students.promotion.management' , [
            'promotions' => $promotions, 
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

         DB::beginTransaction();

        try {

            $students = student::where('Grade_id',$request->Grade_id)->where('Classroom_id',   $request->Classroom_id)->where('section_id',$request->section_id)->where('academic_year' , $request->academic_year)->get();

            // return $students;

            if($students->count() < 1){
                return redirect()->back()->with('error_promotions', __('لاتوجد بيانات في جدول الطلاب'));
            }

            // update in table student
            foreach ($students as $student){

                $ids = explode(',' , $student->id);
                Student::whereIn('id', $ids)
                    ->update([
                        'gender_id'=>$request->Grade_id_new,
                        'Classroom_id'=>$request->Classroom_id_new,
                        'section_id'=>$request->section_id_new,
                        'academic_year' => $request->academic_year_new,
                    ]);

                // insert into promotions
                Promotion::updateOrCreate([
                    'student_id'=>$student->id,
                    'from_grade'=>$request->Grade_id,
                    'from_Classroom'=>$request->Classroom_id,
                    'from_section'=>$request->section_id,
                    'to_grade'=>$request->Grade_id_new,
                    'to_Classroom'=>$request->Classroom_id_new,
                    'to_section'=>$request->section_id_new,
                    'academic_year'=>$request->academic_year,
                    'academic_year_new'=>$request->academic_year_new,
                ]);

            }
             DB::commit();
            toastr()->success(trans('message.success'));
            return redirect()->back();

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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

        DB::beginTransaction();
            try {
                if($request->page_id ==1) {
                    $promotions = Promotion::all();
                    foreach ($promotions as $promotion){
                        $ids = explode(',' , $promotion->student_id);
                        Student::whereIn('id' , $ids)
                                    ->update([
                                        'Grade_id' => $promotion->from_grade ,
                                        'Classroom_id' => $promotion->from_Classroom ,
                                        'section_id' => $promotion->from_section ,
                                        'academic_year' => $promotion->academic_year,
                                    ]);

                        Promotion::truncate();
                    }

                        DB::commit();
                        toastr()->error(trans('message.Delete'));
                        return redirect()->back();
                }else{
                    // return $request;
                    
                    $Promotion = Promotion::findorfail($request->id);
                    // $Promotion = Promotion::where('student_id' , $request->student_id)->get();
                    
                    Student::where('id' , $Promotion->student_id)
                                ->update([
                                    'Grade_id' => $Promotion->from_grade ,
                                    'Classroom_id' => $Promotion->from_Classroom ,
                                    'section_id' => $Promotion->from_section ,
                                    'academic_year' => $Promotion->academic_year,
                                ]);
                                Promotion::destroy($request->id);
       
                    DB::commit();
                    toastr()->error(trans('message.Delete'));
                    return redirect()->back();
                }
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }
        
    }
}
