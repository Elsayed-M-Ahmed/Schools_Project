<?php

namespace App\Http\Controllers\Teachers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Section;
use App\Models\Attendance;

class StudentController extends Controller
{

    public function index()
    {
        $ids = DB::table('teacher_section')->where('teacher_id' , auth()->user()->id)->pluck('section_id');
        $students = Student::whereIn('section_id' , $ids)->get();
        return view('pages.Teachers.dashboard.students.index',compact('students'));
    }

    public function sections() {
        // return "true";
        $ids = DB::table('teacher_section')->where('teacher_id' , auth()->user()->id)->pluck('section_id');
        $sections = Section::whereIn('id' , $ids)->get();
        return view('pages.Teachers.dashboard.sections.index',compact('sections'));
    }

    public function attendance(Request $request)
    {
        // return $request;

        try {

            $attenddate = date('Y-m-d');
            $classid = $request->section_id;
            foreach ($request->attendences as $studentid => $attendence) {

                

                $attendence_date_count = Attendance::where('attendence_date' , date('Y-m-d'))->where('student_id' ,$studentid)->count();

                if ($attendence_date_count == 0) {
                    // return $request;

                    if ($attendence == 'presence') {
                        $attendence_status = true;
                    } else if ($attendence == 'absent') {
                        $attendence_status = false;
                    }

                    Attendance::create([
                        'student_id' => $studentid,
                        'grade_id' => $request->grade_id,
                        'classroom_id' => $request->classroom_id,
                        'section_id' => $request->section_id,
                        'teacher_id' => auth()->user()->id,
                        'attendence_date' => date('Y-m-d'),
                        'attendence_status' => $attendence_status,
                    ]);
                }else {
                    
                    if ($attendence == 'presence') {
                        $attendence_status = true;
                    } else if ($attendence == 'absent') {
                        $attendence_status = false;
                    }
                    // return $request;
                    Attendance::where('attendence_date' , date('Y-m-d'))->where('student_id' ,$studentid)->update([
                        'attendence_date' => date('Y-m-d'),
                        'attendence_status' => $attendence_status,
                        'student_id' => $studentid,
                        'grade_id' => $request->grade_id,
                        'classroom_id' => $request->classroom_id,
                        'section_id' => $request->section_id,
                        'teacher_id' => auth()->user()->id,
                        
                        
                    ]);
                }
            }
            toastr()->success(trans('message.success'));
            return redirect()->back();
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function attendanceReport(Request $request) {
        // return "true";

        $ids = DB::table('teacher_section')->where('teacher_id' , auth()->user()->id)->pluck('section_id');
        // return $ids;
        $students = Student::whereIn('id' , $ids)->get();
        return view('pages.Teachers.dashboard.students.attendance_report', compact('students'));    

    }

    public function attendanceSearch  (Request $request) {

        $request->validate([
            'from'  =>'required|date|date_format:Y-m-d',
            'to'=> 'required|date|date_format:Y-m-d|after_or_equal:from'
        ],[
            'to.after_or_equal' => '?????????? ?????????????? ???????? ???? ???????? ???? ?????????? ?????????????? ???? ????????????',
            'from.date_format' => '???????? ?????????????? ?????? ???? ???????? yyyy-mm-dd',
            'to.date_format' => '???????? ?????????????? ?????? ???? ???????? yyyy-mm-dd',
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
}
