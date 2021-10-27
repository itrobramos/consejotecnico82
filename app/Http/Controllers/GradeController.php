<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class GradeController extends Controller
{
    

    public function index(Request $request)
    {
        $query = Grade::where('schoolId', Auth::user()->schoolId)->orderBy('grade', 'asc')->orderBy('hall', 'asc');
        $grades = $query->paginate();
        return view('grades.index',compact('grades'));
    }
    

    public function create()
    {
        return view('grades.add');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'grade' => 'required',
        ]);


        $grade = new Grade();
        $grade->grade = $request->grade;
        $grade->hall = $request->hall;
        $grade->schoolId = Auth::user()->schoolId;
        $grade->save();

        return redirect('grades')->with('success','Grado creado correctamente.');
    }

   

    public function edit($id)
    {
        $grade = Grade::findOrFail($id);
        return view('grades.edit',compact('grade'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'grade' => 'required',
        ]);

        $grade = Grade::findOrFail($id);
        $grade->grade = $request->grade;
        $grade->hall = $request->hall;
        $grade->save();

        return redirect('grades')->with('success','Grado editado correctamente.');
    }

    public function destroy($id)
    {
        Grade::destroy($id);
        return redirect('grades')->with('success','Grado eliminado correctamente.');
    }

   

   
}
