<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use App\Models\Format;
use App\Models\SendFormat;
use App\Models\Grade;
use App\Models\SentFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormatController extends Controller
{
    public function __construct(){
        // $this->middleware(function ($request, $next) {
        //     $userSession = Auth::user();
        //     if(!$this->checkRoleRoutePermission($userSession)){
        //         return response()->view('errors.error');
        //     }
        //     return $next($request);
        // });
    }

    public function index(Request $request)
    {
        $query = Format::orderBy('name', 'asc');
        $formats = $query->paginate();
        return view('formats.index',compact('formats'));
    }
    

    public function create()
    {
        return view('formats.add');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required'
        ]);


        $format = new Format();
        $format->name = $request->name;
        $format->description = $request->description;
        $format->beginDate = $request->beginDate;
        $format->endDate = $request->endDate;        
        $format->active = false;
        $format->save();

        return redirect('formats')->with('success','Formato creado correctamente.');
    }

   

    public function edit($id)
    {
        $format = Format::findOrFail($id);
        return view('formats.edit',compact('format'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required'
        ]);

        $format = Format::findOrFail($id);
        $format->name = $request->name;
        $format->description = $request->description;
        $format->beginDate = $request->beginDate;
        $format->endDate = $request->endDate;
        $format->save();

        return redirect('formats')->with('success','Formato editado correctamente.');

    }

    public function destroy($id)
    {
        Format::destroy($id);
        return redirect('formats')->with('success','Formato eliminado correctamente.');
    }

    public function configure($id){
        $format = Format::findOrFail($id);
        //dd($format->categories[0]->questions);
        return view('formats.configure',compact('format'));
    }

    public function configureStore(Request $request, $id){
        $format = Format::findOrFail($id);

        foreach($format->categories as $category){
            foreach($category->questions as $question){
                Question::destroy($question->id);
            }
            Category::destroy($category->id);
        }
        
        foreach($request['category'] as $category){

            $Category = new Category;
            $Category->formatId = $format->id;
            $Category->name= $category['name'];
            $Category->save();

            foreach($category['questions'] as $question){

                $Question = new Question;
                $Question->categoryId = $Category->id;
                $Question->name= $question['question'];
                $Question->type= $question['type'];
                $Question->save();
            }
        }

        return redirect('formats')->with('success','Formato configurado correctamente.');
    }

    public function answer($id){
        $format = Format::findOrFail($id);
        $grades = Grade::where('schoolId',Auth::user()->schoolId)->get();
        $answers = Answer::where('formatId', $id)->where('schoolId', Auth::user()->schoolId)->get();


        return view('formats.answer',compact('format', 'grades', 'answers'));
    }

    public function answerpost(Request $request, $id){


        $answers = Answer::where('formatId', $id)->where('schoolId', Auth::user()->schoolId)->get();

        foreach($answers as $answer){
            Answer::destroy($answer->id);
        }

        foreach($request->answer as $grade => $j ){

            foreach($j as $question => $answ){
                if($answ != null && $answ != ''){
                    $answer = new Answer();
                    $answer->schoolId = Auth::user()->schoolId;
                    $answer->answer = $answ;
                    $answer->questionId = $question;
                    $answer->gradeId = $grade;
                    $answer->formatId = $id;
                    $answer->save();    
                }
            }
        }

        return redirect('home')->with('success','Formato guardado correctamente.');

    }


    public function send($id){

        $SentFormat = new SentFormat();
        $SentFormat->formatId = $id;
        $SentFormat->schoolId = Auth::user()->schoolId;
        $SentFormat->userId = Auth::user()->id;
        $SentFormat->save();

        return redirect('home')->with('success','Formato enviado correctamente al Consejo Técnico.');
    }


    public function details($id){

        $format = Format::find($id);
        $grades = Grade::where('schoolId',Auth::user()->schoolId)->get();
        $answers = Answer::where('formatId', $id)->where('schoolId', Auth::user()->schoolId)->get();


        return view('formats.details',compact('format', 'grades', 'answers'));
    }
   
}
