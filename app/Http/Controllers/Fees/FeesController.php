<?php

namespace App\Http\Controllers\Fees;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fees;
use App\Models\Grade;

class FeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Grades = Grade::all();
        $fees = Fees::all();
        return view('Pages.Fees.index' , [
            'Grades' => $Grades ,
            'fees' => $fees 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Grades = Grade::all();
        $fees = Fees::all();
        return view('Pages.Fees.add' , [
            'Grades' => $Grades ,
            'fees' => $fees 
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
        Fees::create([
            'title' => ['ar' => $request->title_ar , 'en' => $request->title_en] ,
            'amount' => $request->amount ,
            'Grade_id' => $request->Grade_id ,
            'Classroom_id' => $request->Classroom_id ,
            'year' => $request->year ,
            'Fee_type' => $request->Fee_type ,
            'description' => $request->description ,
        ]);

        toastr()->success(trans('message.success'));
        return redirect()->route('Fees.index');

        }catch (\Exception $e) {
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
        $Grades = Grade::all();
        $fee = Fees::findOrFail($id);
        return view('Pages.Fees.edit' , [
            'Grades' => $Grades ,
            'fee' => $fee
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
            Fees::where('id' , $request->id)->update([
                'title' => ['ar' => $request->title_ar , 'en' => $request->title_en] ,
                'amount' => $request->amount ,
                'Grade_id' => $request->Grade_id ,
                'Classroom_id' => $request->Classroom_id ,
                'year' => $request->year ,
                'Fee_type' => $request->Fee_type ,
                'description' => $request->description ,
            ]);

            toastr()->success(trans('message.success'));
            return redirect()->route('Fees.index');
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
        // return $request;

        Fees::where('id' , $request->id)->delete();
        toastr()->error(trans('message.success'));
        return redirect()->route('Fees.index');
    }
}
