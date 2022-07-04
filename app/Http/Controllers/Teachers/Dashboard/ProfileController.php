<?php

namespace App\Http\Controllers\Teachers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
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
        // return 'true';
        $teacher_information = Teacher::findOrFail(auth()->user()->id);
        return view('pages.Teachers.dashboard.profile' , compact('teacher_information'));
        
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
     
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        // return $request;

        try {
            $teacher_information = Teacher::findOrFail($id);

            $teacher_information->Name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $teacher_information->password = Hash::make($request->password);
            $teacher_information->save();

            toastr()->success(trans('message.success'));
            return redirect()->route('profile.index');
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

            $teacher_information = Teacher::findOrFail($id);
            // return $teacher_information->password .  ',,,,' .md5($request->password);
            // md5($request->password) == $teacher_information->password;
            // Hash::check($request->password , $teacher_information->password);
                if (Hash::check($request->password , $teacher_information->password)) {
                    return view('pages.Teachers.dashboard.profile_edit' , compact('teacher_information'));
                   

                }else{
                    return redirect()->route('profile.index');
                    
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
