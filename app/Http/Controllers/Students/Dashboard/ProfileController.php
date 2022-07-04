<?php

namespace App\Http\Controllers\Students\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return "true";

        $student_information = Student::findOrFail(auth()->user()->id);
        // return $student_information;

        return view('pages.students.Dashboard.Profile.profile' , compact('student_information'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request ,$id)
    {
         // return $request;

         try {
            $teacher_information = Student::findOrFail($id);

            $teacher_information->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $teacher_information->password = Hash::make($request->password);
            $teacher_information->save();

            toastr()->success(trans('message.success'));
            return redirect()->route('Student_profile.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
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

        $student_information = Student::findOrFail($id);
        // return $student_information->password .  ',,,,' .md5($request->password);
            if (Hash::check($request->password , $student_information->password)) {
                return view('pages.students.Dashboard.Profile.profile_edit' , compact('student_information'));
               
            }else{
                return redirect()->route('Student_profile.index');
            
            }
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
