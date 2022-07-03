<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Library;
use App\Models\Grade;
use App\Models\Subject;
use App\Http\Traits\AttachFilesTrait;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     use AttachFilesTrait;

    public function index()
    {
        $books = Library::all();
        return view('pages.library.index' , [
            'books' => $books ,
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
        $subjects = Subject::all();
        return view('pages.library.create' , [
            'grades' => $grades ,
            'subjects' => $subjects ,
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
        try{
        Library::create([
            'title' => $request->title ,
            'file_name' => $request->file('file_name')->getClientOriginalName() ,
            'Grade_id' => $request->Grade_id ,
            'Classroom_id' => $request->Classroom_id ,
            'section_id' => $request->section_id ,
            'subject_id' => $request->Subject_id ,
            'teacher_id' => auth()->user()->id ,
        ]);

        $this->uploadfile($request , 'file_name' , 'library');

        toastr()->success(trans('message.success'));
        return redirect()->route('library.index');
    } catch (\Exception $e) {
        return redirect()->back()->with(['error' => $e->getMessage()]);
    }
    }

    public function downloadAttachment($filename)
    {
        return response()->download(public_path('attachments/library/'.$filename));
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
        $grades = Grade::all();
        $book = library::findorFail($id);
        $subjects = Subject::all();
        return view('pages.library.edit',compact('book','grades','subjects'));
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

            $book = library::findorFail($request->id);
            $book->title = $request->title;

            if($request->hasfile('file_name')){

                $this->deleteFile($book->file_name , 'library');

                $this->uploadFile($request,'file_name' , 'library');

                $new_file_name = $request->file('file_name')->getClientOriginalName();
                $book->file_name = $new_file_name;
            }

            $book->Grade_id = $request->Grade_id;
            $book->classroom_id = $request->Classroom_id;
            $book->section_id = $request->section_id;
            $book->teacher_id = 1;
            $book->save();
            toastr()->success(trans('message.Update'));
            return redirect()->route('library.index');
        } catch (\Exception $e) {
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
        $this->deletefile($request->file_name);
        Library::destroy($request->id);
        toastr()->error(trans('message.Delete'));
        return redirect()->route('library.index');
    }
}
