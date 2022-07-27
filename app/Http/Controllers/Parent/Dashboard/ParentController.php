<?php

namespace App\Http\Controllers\Parent\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Parents;
use App\Models\Attendance;
use App\Models\Quizze;
use App\Models\Degree;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ParentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return "true";
        $sons = Student::where('parent_id' , auth()->user()->id)->get();

        $sons_id = Student::where('parent_id' , auth()->user()->id)->pluck('id');
        // return $sons;

        $sons_data = Attendance::whereIn('student_id' , $sons_id)->get();
        
        return view('pages.Parents.Dashboard.Attendance.attendance_report' , compact('sons_data' , 'sons'));

    }


    public function attendanceSearch  (Request $request) {
        // return "true";
        $request->validate([
            'from'  =>'required|date|date_format:Y-m-d',
            'to'=> 'required|date|date_format:Y-m-d|after_or_equal:from'
        ],[
            'to.after_or_equal' => 'تاريخ النهاية لابد ان اكبر من تاريخ البداية او يساويه',
            'from.date_format' => 'صيغة التاريخ يجب ان تكون yyyy-mm-dd',
            'to.date_format' => 'صيغة التاريخ يجب ان تكون yyyy-mm-dd',
        ]);


        $ids = DB::table('teacher_section')->where('teacher_id', auth()->user()->id)->pluck('section_id');
        $students = Student::whereIn('section_id', $ids)->get();

   if($request->student_id == 0){

       $Students = Attendance::whereBetween('attendence_date', [$request->from, $request->to])->get();
       return view('pages.Teachers.dashboard.students.attendance_report',compact('Students','students'));
   }

   else{

       $Students = Attendance::whereBetween('attendence_date', [$request->from, $request->to])
       ->where('student_id',$request->student_id)->get();
       return view('pages.Teachers.dashboard.students.attendance_report',compact('Students','students'));


   }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return "true";

        $parent_information = Parents::findOrFail(auth()->user()->id);

        // return $parent_information;
        return view('pages.Parents.Dashboard.Profile.profile' , compact('parent_information'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
         // return $request;

         $parent_information = Parents::findOrFail($id);
         
             if (Hash::check($request->password , $parent_information->password)) {
                 return view('pages.Parents.Dashboard.Profile.profile_edit' , compact('parent_information'));
             }else{
                 return redirect()->route('parent.create');
                 
             }
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
        // return $request;

        try {
            $parent_information = Parents::findOrFail($id);

            $parent_information->Name_Father = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $parent_information->password = Hash::make($request->password);
            $parent_information->save();

            toastr()->success(trans('message.success'));
            return redirect()->route('parent.create');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function sons_exams_results () {
        // return "true";

        $data['sons_id'] = Student::where('parent_id' , auth()->user()->id)->value('id');
        $data['sons_data'] = Student::where('parent_id' , auth()->user()->id)->get();
        $data['sons_section_id'] = Student::where('parent_id' , auth()->user()->id)->value('section_id');
        $data['quizze_id'] = Quizze::where('section_id' , $data['sons_section_id'])->value('id');
        $data['quizze_name'] = Quizze::where('section_id' , $data['sons_section_id'])->value('name');
        $data['sons_degree'] = Degree::where('quizze_id' , $data['quizze_id'] && 'student_id' , $data['sons_id'])->value('score');
        return view('pages.Parents.Dashboard.exams_results.view_exams_results' , $data);
    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
