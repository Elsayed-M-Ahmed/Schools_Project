<?php

namespace App\Http\Controllers\Students;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\Gender;
use App\Models\Grade;
use App\Models\Parents;
use App\Models\Nationalitie;
use App\Models\Section;
use App\Models\Student;
use App\Models\Blood_type;
use App\Models\Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all();

        return view('pages.students.index' , [
            'students' => $students ,
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $my_classes = Grade::all();
        $Genders = Gender::all();
        $parents = Parents::all();
        $nationals = Nationalitie::all();
        $bloods = Blood_type::all();

        return view('pages.students.add_student' , [
            'my_classes' => $my_classes ,
            'Genders' => $Genders ,
            'parents' => $parents ,
            'nationals' => $nationals ,
            'bloods' => $bloods,
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

        // عشان لو فى خطا فى اى عمليه من الاتنين مينفزش التانيه
        DB::beginTransaction();

        try {
            $students = new Student();
            $students->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $students->email = $request->email;
            $students->password = md5($request->password);
            $students->gender_id = $request->gender_id;
            $students->nationalitie_id = $request->nationalitie_id;
            $students->blood_id = $request->blood_id;
            $students->Date_Birth = $request->Date_Birth;
            $students->Grade_id = $request->Grade_id;
            $students->Classroom_id = $request->Classroom_id;
            $students->section_id = $request->section_id;
            $students->parent_id = $request->parent_id;
            $students->academic_year = $request->academic_year;
            $students->save();

            // insert image
            if($request->hasfile('photos'))
            {
                foreach($request->file('photos') as $file)
                {
                    $name = $file->getClientOriginalName();
                    // $image_extension = $file->getClientOriginalExtension();
                    
                    // insert in image_table
                    $images= new Image();
                    $images->file_name=$name;
                    $images->imageable_id= $students->id;
                    $images->imageable_type = 'Student::class';
                    $images->save();

                    $file->storeAs('attachments/students/'.$students->name . '-' . $students->id, $name ,'upload_attachments');
                }
            }

            //  لو الاتنين صح ينفذ الاتنين 
            DB::commit();

            toastr()->success(trans('message.success'));
            return redirect()->route('Students.create');
        }

        catch (\Exception $e){

            // عشان يحذف الاضافه اللى تمت رغم وجود خطا فى الاضافه الاخرى
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
        $Student = Student::findOrFail($id);
        $images = Image::where('imageable_id' , $Student->id)->get();
        return view('pages.students.show' , [
            'Student' => $Student,
            'images' => $images,
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
        $Students = Student::findOrFail($id);
        // return $Students;
        $Grades = Grade::all();
        $Genders = Gender::all();
        $parents = Parents::all();
        $nationals = Nationalitie::all();
        $bloods = Blood_type::all();

        

        return view('pages.Students.edit' , [
            'Grades' => $Grades ,
            'Genders' => $Genders ,
            'parents' => $parents ,
            'nationals' => $nationals ,
            'bloods' => $bloods,
            'Students' => $Students ,
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
            $Edit_Students = Student::findorfail($request->id);
            $Edit_Students->name = ['ar' => $request->name_ar, 'en' => $request->name_en];
            $Edit_Students->email = $request->email;
            $Edit_Students->password = md5($request->password);
            $Edit_Students->gender_id = $request->gender_id;
            $Edit_Students->nationalitie_id = $request->nationalitie_id;
            $Edit_Students->blood_id = $request->blood_id;
            $Edit_Students->Date_Birth = $request->Date_Birth;
            $Edit_Students->Grade_id = $request->Grade_id;
            $Edit_Students->Classroom_id = $request->Classroom_id;
            $Edit_Students->section_id = $request->section_id;
            $Edit_Students->parent_id = $request->parent_id;
            $Edit_Students->academic_year = $request->academic_year;
            $Edit_Students->save();
            toastr()->success(trans('message.Update'));
            return redirect()->route('Students.index');
        } catch (\Exception $e) {
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
        $student = Student::findOrFail($request->id)->delete();
        toastr()->error(trans('message.Delete'));
        return redirect()->route('Students.index');
    }

    public function Get_classrooms($id) {
        $list_classes = Classroom::Where('Grade_id' , $id)->pluck('classroom_name' , 'id');
        return $list_classes;
    }

    public function Get_Sections($id) {
        $list_sections = Section::Where('Class_id' , $id)->pluck('Name_Section' , 'id');
        return $list_sections;
    }

    public function Upload_attachment(Request $request)
    {
        // return $request;
        foreach($request->file('photos') as $file)
                {
                    $name = $file->getClientOriginalName();
                    // $image_extension = $file->getClientOriginalExtension();
                    
                    // insert in image_table
                    $images= new Image();
                    $images->file_name=$name;
                    $images->imageable_id= $request->student_id;
                    $images->imageable_type = 'Student::class';
                    $images->save();

                    $file->storeAs('attachments/students/'.$request->student_name . '-' . $request->student_id, $name ,'upload_attachments');
                }
        toastr()->success(trans('messages.success'));
        return redirect()->route('Students.show',$request->student_id);
    }


    public function Download_attachment($studentname, $filename , $student_id)
    {
        return response()->download(public_path('attachments/students/'.$studentname . '-' . $student_id.'/'. $filename));
    }

    public function Delete_attachment(Request $request)
    {
        // return $request;
        // Delete img in server disk
        Storage::disk('upload_attachments')->delete('attachments/students/'.$request->student_name . '-' . $request->student_id.'/'.$request->filename);

        // Delete in data
        image::where('id',$request->id)->where('file_name',$request->filename)->delete();
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Students.show');
    }
    
}
