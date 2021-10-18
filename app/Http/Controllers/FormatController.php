<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Question;
use App\Models\Format;
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
        $query = Format::where('active', true)->orderBy('name', 'asc');
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
        $format->active = true;
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
   

   
}
