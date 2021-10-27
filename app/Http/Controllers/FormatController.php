<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use App\Models\Format;
use App\Models\Grade;
use App\Models\SentFormat;
use App\Models\School;
use App\Models\SchoolFormat;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Collection\Collection;


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

    public function index(Request $request){
        $formats = Format::orderBy('beginDate')->get();
        return view('formats.index',compact('formats'));
    }

    public function create(){
        return view('formats.add');
    }

    public function store(Request $request){
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

    public function edit($id){
        $format = Format::findOrFail($id);
        return view('formats.edit',compact('format'));
    }

    public function update(Request $request, $id){
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

    public function destroy($id){
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
        $grades = Grade::where('schoolId',Auth::user()->schoolId)->orderBy('grade','asc')->orderBy('hall','asc')->get();
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

        $SchoolFormat = SchoolFormat::where('schoolId', Auth::user()->schoolId)
                                    ->where('formatId', $id)->first();
        $SchoolFormat->ended = 1;
        $SchoolFormat->save();                                   

        return redirect('home')->with('success','Formato enviado correctamente al Consejo Técnico.');
    }

    public function details(Request $request, $id){

        if (Auth::user()->userTypeId == 2){ //Directora
            $format = Format::find($id);
            $grades = Grade::where('schoolId',Auth::user()->schoolId)->orderBy('grade','asc')->orderBy('hall','asc')->get();
            $answers = Answer::where('formatId', $id)->where('schoolId', Auth::user()->schoolId)->get();
            $schools = School::where('id',Auth::user()->schoolId)->get();
            $selected = Auth::user()->schoolId;
        }
        else{

            $format = Format::find($id);
            $schools = School::orderBy('name','asc')->get();

            if(isset($request->schoolId) && $request->schoolId > 0){
                $grades = Grade::where('schoolId', $request->schoolId)->select('grade')->distinct()->get();
                $answers = Answer::where('formatId', $id)->where('schoolId', $request->schoolId)->get();
                $selected = $request->schoolId;

                $answers = DB::select(' SELECT q.id questionId, q.name, g.grade, sum(a.answer) as answer 
                FROM answers a
                    INNER JOIN grades g on g.id = a.gradeId 
                    INNER JOIN questions q on q.id = a.questionId
                    INNER JOIN categories c on c.id = q.categoryId
                    INNER JOIN formats f on f.id = c.formatId
                WHERE f.id = ' . $id . '
                    AND a.schoolId = ' . $request->schoolId . ' 
                    AND q.type = "number"
                GROUP BY q.id, q.name, g.grade');
            }
            else{
                $grades = Grade::select('grade')->distinct()->get();
                $answers = Answer::where('formatId', $id)->get();   
                $selected = 0; 

                $answers = DB::select(' SELECT q.id questionId, q.name, g.grade, sum(a.answer) as answer 
                FROM answers a
                    INNER JOIN grades g on g.id = a.gradeId 
                    INNER JOIN questions q on q.id = a.questionId
                    INNER JOIN categories c on c.id = q.categoryId
                    INNER JOIN formats f on f.id = c.formatId
                WHERE f.id = ' . $id . '
                    AND q.type = "number"
                GROUP BY q.id, q.name, g.grade');
            }
            

           


            $answers = collect($answers);


        }

        return view('formats.details',compact('format', 'grades', 'answers', 'schools', 'selected'));
    }
   
    public function graphs(Request $request, $id){


        if (Auth::user()->userTypeId == 2){ //Directora
            $format = Format::find($id);
            $grades = Grade::where('schoolId',Auth::user()->schoolId)->get();
            $answers = Answer::where('formatId', $id)->where('schoolId', Auth::user()->schoolId)->get();
            $schools = School::where('id',Auth::user()->schoolId)->get();
            $selected = Auth::user()->schoolId;
            $graphs = [];
    
    
            foreach($format->categories as $category){
                foreach($category->questions as $question){
                    
                    $gradesarray = [];
    
                    if($question->type=="number"){
                        
                        foreach($grades as $grade){
    
                            $answer = Answer::where('questionId', $question->id)
                                            ->where('schoolId', Auth::user()->schoolId)
                                            ->where('gradeId', $grade->id)
                                            ->where('formatId', $id)->first();
    
                            if($answer == null)
                                $answer1 = 0;
                            else    
                                $answer1 = $answer->answer;
    
                            $gradesarray[] = ["grade" => $grade->grade,
                                              "hall" => $grade->hall,
                                              "answer" => $answer1
                                             ];
                        }
    
                        $graphs[] = ["question" => $question->name,
                                     "questionId" => $question->id,
                                     "grades" => $gradesarray
                                    ];
                    }
                }
            }
    
    
        }
        else{
            $format = Format::find($id);
            $schools = School::orderBy('name','asc')->get();
            $graphs = [];

            if(isset($request->schoolId) && $request->schoolId > 0){
                $grades = Grade::select('grade')->distinct()->get();
                $answers = Answer::where('formatId', $id)->where('schoolId', $request->schoolId)->get();
                $selected = $request->schoolId;

                $answers = DB::select(' SELECT q.id questionId, q.name, g.grade, sum(a.answer) as answer 
                                        FROM answers a
                                            INNER JOIN grades g on g.id = a.gradeId 
                                            INNER JOIN questions q on q.id = a.questionId
                                            INNER JOIN categories c on c.id = q.categoryId
                                            INNER JOIN formats f on f.id = c.formatId
                                        WHERE f.id = ' . $id . '
                                            AND a.schoolId = ' . $request->schoolId . ' 
                                            AND q.type = "number"
                                        GROUP BY q.id, q.name, g.grade');
            }
            else{
                $grades = Grade::select('grade')->distinct()->get();
                $answers = Answer::where('formatId', $id)->get();
                $selected = 0; 

                $answers = DB::select(' SELECT q.id questionId, q.name, g.grade, sum(a.answer) as answer 
                                        FROM answers a
                                            INNER JOIN grades g on g.id = a.gradeId 
                                            INNER JOIN questions q on q.id = a.questionId
                                            INNER JOIN categories c on c.id = q.categoryId
                                            INNER JOIN formats f on f.id = c.formatId
                                        WHERE f.id = ' . $id . '
                                            AND q.type = "number"
                                        GROUP BY q.id, q.name, g.grade');

            }


            $answers = collect($answers);

            if($answers->count() > 0){
                $lastQuestion = $answers->first()->questionId;
                $lastQuestionName = $answers->first()->name;
    
                $reinicio = 0;
                $gradesarray = [];
                foreach($answers as $answer){
                    if($answer->questionId == $lastQuestion){
    
                        $gradesarray[] = [
                                           "grade" => $answer->grade,
                                           "answer" => $answer->answer
                                         ];
    
                        $reinicio = 1;
                    }
                    else{
                        if($reinicio == 1){
    
                            $graphs[] = ["question" => $lastQuestionName,
                                "questionId" => $lastQuestion,
                                "grades" => $gradesarray
                            ];
                        }
    
                        $gradesarray = [];
                        $reinicio = 0;
                        $gradesarray[] = [
                            "grade" => $answer->grade,
                            "answer" => $answer->answer
                        ];
                    }
    
                    $lastQuestion = $answer->questionId;
                    $lastQuestionName = $answer->name;
                }
    
    
                $graphs[] = ["question" => $answer->name,
                             "questionId" => $answer->questionId,
                             "grades" => $gradesarray
                            ];
            
    
            }
        }

        return view('formats.graphs',compact('format', 'graphs', 'schools', 'selected'));

    }

    public function activate($id){
        $format = Format::findOrFail($id);
        $schools = School::get();
        return view('formats.activate',compact('format', 'schools'));
    }

    public function activatepost(Request $request, $id){


        $SchoolFormats = SchoolFormat::where('formatId', $id)->get();
        foreach($SchoolFormats as $SchoolFormat){
            SchoolFormat::destroy($SchoolFormat->id);
        }

        foreach($request->schools as $schoolId => $on){

            $SchoolFormat = new SchoolFormat();
            $SchoolFormat->schoolId = $schoolId;
            $SchoolFormat->formatId = $id;
            $SchoolFormat->ended = false;
            $SchoolFormat->save();
            
        }

        $Format = Format::find($id);
        $Format->active = true;
        $Format->save();

        return redirect('formats')->with('success','Formato activado correctamente.');
    }

}

