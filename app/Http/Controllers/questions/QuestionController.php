<?php

namespace App\Http\Controllers\questions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Quizze;

class QuestionController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function get_qustions($id)
    {
        // return $id;
        $questions = Question::findorfail($id)->get();
        return view('pages.Questions.index', compact('questions'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
        Question::create([
            'title' => $request->title ,
            'answers' => $request->answers ,
            'right_answer' => $request->right_answer ,
            'quizze_id' => $request->quizze_id ,
            'score' => $request->score,
        ]);
        toastr()->success(trans('message.success'));
            return redirect()->route('Quizzes.index');
        } catch (\Exception $e) {
            return redirect()->route('Quizzes.index')->with(['error' => $e->getMessage()]);
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
        $quizze = Quizze::findorfail($id);
        // return $quizze
        return view('pages.Questions.create',compact('quizze'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::findorfail($id);
        return view('pages.Questions.edit' , [
            'question' => $question ,
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
        try{
        Question::where('id' , $request->id)->update([
            'title' => $request->title ,
            'answers' => $request->answers ,
            'right_answer' => $request->right_answer ,
            'quizze_id' => $request->quizze_id ,
            'score' => $request->score,
        ]);
        toastr()->success(trans('message.success'));
            return redirect('get_qustions/' . $request->quizze_id);
        } catch (\Exception $e) {
            return redirect('get_qustions/' . $request->quizze_id)->with(['error' => $e->getMessage()]);
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
        try {
            Question::destroy($request->id);
            toastr()->error(trans('message.Delete'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
