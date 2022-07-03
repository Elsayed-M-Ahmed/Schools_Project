<?php 

namespace App\Http\Controllers\Grades;
use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Grade;
use App\Http\Requests\Create_Grade_Request;

use Illuminate\Http\Request;

class GradeController extends Controller 
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $Grades = Grade::all();
    return view('pages.grades.grades' , [
      'Grades' => $Grades,
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create(Create_Grade_Request $request)
  {

    if (Grade::where('Name->ar' , $request->Name)->orwhere('Name->ar' , $request->Name_en)->exists()) {
      toastr()->error(trans('Grades_trans.exists'));
      return redirect()->back();
    }

    try {
      $validated = $request->validated();
      $Grade = new Grade();
      $Grade->Name = ['en' => $request->Name_en, 'ar' => $request->Name];
      $Grade->Notes = $request->Notes;
      $Grade->save();
      toastr()->success(trans('message.success'));
      return redirect()->route('grade.index');
    } catch (\Exception $e) {
      return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
    
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
    
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(Create_Grade_Request $request)
  {
    // return $request;
    $validated = $request->validated();
    $grades = Grade::findOrFail($request->id);
    $grades->update([
      'Name' => ['ar' => $request->Name, 'en' => $request->Name_en],
      'Notes' => $request->Notes,
    ]);
    toastr()->success(trans('message.Update'));
       return redirect()->route('grade.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy(Request $request)
  {
    $classroom_id = Classroom::where("Grade_id" , "=" , $request->id)->pluck('Grade_id');
    //  return $classroom_id->count();
    if ($classroom_id->count() == 0) {
      $grades = Grade::findOrFail($request->id)->delete();
      toastr()->error(trans('messages.Delete'));
      return redirect()->route('grade.index');
    }else{
      toastr()->error(trans('Grades_trans.delete_Grade_Error'));
      return redirect()->route('grade.index');
    }
    
  }
  
}

?>