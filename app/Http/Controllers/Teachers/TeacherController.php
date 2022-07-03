<?php

namespace App\Http\Controllers\Teachers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Repository\TeacherRepositoryInterface;
use App\Models\Teacher;
use App\Models\Specialization;
use App\Models\Gender;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{

    // protected $Teachers;
    // public function __construct(TeacherRepositoryInterface $Teachers) {
    //     $this->Teachers = $Teachers;
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    //   $Teachers = $this->Teachers->getAllTeachers();

        $Teachers = Teacher::all();
        return view('pages.Teachers.Teachers',compact('Teachers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $specializations = Specialization::all();
        $genders  = Gender::all();

        return view('pages.Teachers.create', [
            'specializations' => $specializations,
            'genders' => $genders,
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
      
        try {
            $Teachers = new Teacher();
            $Teachers->email = $request->Email;
            $Teachers->password =  Hash::make($request->Password);
            $Teachers->Name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $Teachers->Specialization_id = $request->Specialization_id;
            $Teachers->Gender_id = $request->Gender_id;
            $Teachers->Joining_Date = $request->Joining_Date;
            $Teachers->Address = $request->Address;
            $Teachers->save();
            toastr()->success(trans('message.success'));
            return redirect()->route('Teachers.index');
        }
        catch (Exception $e) {
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
        $Teachers = Teacher::findOrFail($id);
        $specializations = Specialization::all();
        $genders  = Gender::all();

        return view('pages.Teachers.Edit', [
            'specializations' => $specializations,
            'genders' => $genders,
            'Teachers' => $Teachers, 
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
            $Teachers = Teacher::findOrFail($request->id);
            $Teachers->email = $request->Email;
            $Teachers->password =  md5($request->Password);
            $Teachers->Name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $Teachers->Specialization_id = $request->Specialization_id;
            $Teachers->Gender_id = $request->Gender_id;
            $Teachers->Joining_Date = $request->Joining_Date;
            $Teachers->Address = $request->Address;
            $Teachers->save();
            toastr()->success(trans('message.Update'));
            return redirect()->route('Teachers.index');
        }
        catch (Exception $e) {
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
        $Teachers = Teacher::findOrFail($request->id)->delete();
        toastr()->error(trans('message.Delete'));
        return redirect()->route('Teachers.index');
    }
}
