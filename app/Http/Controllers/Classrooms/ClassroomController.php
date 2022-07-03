<?php 

namespace App\Http\Controllers\Classrooms;
use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Grade;
use Illuminate\Http\Request;

class ClassroomController extends Controller 
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
      $Grades = Grade::all();
      $My_Classes = Classroom::all();
      return view('pages.classrooms.classrooms' , [
        'My_Classes' => $My_Classes,
        'Grades' => $Grades,
      ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
    // return $request;
    $list_classes = $request->List_Classes;
    try {
    foreach ($list_classes as $List_Class) {
      $classes = new Classroom;
      $classes->classroom_name = ['en' => $List_Class['Name_class_en'], 'ar' => $List_Class['Name']];
      $classes->Grade_id = $List_Class['Grade_id'];
      $classes->save();
    }
    toastr()->success(trans('message.success'));
    return redirect()->route('Classrooms.index');
  }  catch (\Exception $e) {
    return redirect()->back()->withErrors(['error' => $e->getMessage()]);
  }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show(Request $request)
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
  public function update(Request $request)
  {
    // return $request;
    $classroom_id = $request->id;
    $grades = Classroom::findOrFail($classroom_id);
    $grades->update([
      'classroom_name' => ['en' => $request->Name_en , 'ar' => $request->Name],
      'Grade_id' => $request->Grade_id,
    ]);
    $grades->save();
    toastr()->success(trans('message.Update'));
    return redirect()->route('Classrooms.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy(Request $request)
  {
    // return $request;
    $classroom = Classroom::findOrFail($request->id)->delete();
    toastr()->error(trans('message.Delete'));
    return redirect()->route('Classrooms.index');
  }

  public function delete_all(Request $request) {
    // return $request;
    $all_checked_id = explode("," , $request->delete_all_id);
    Classroom::whereIn('id' , $all_checked_id)->Delete();
    toastr()->error(trans('message.Delete'));
    return redirect()->route('Classrooms.index');

  }

  public function Filter_Classes(Request $request) {
    // return $request;
    $grades = Grade::findOrFail($request->Grade_id)->get();
    $My_Classes = Classroom::where('Grade_id' , $request->Grade_id)->get();
    return view('pages.classrooms.classrooms' , [
      'My_Classes' => $My_Classes,
      'Grades' => $grades,
    ]);
  }
  
}

?>