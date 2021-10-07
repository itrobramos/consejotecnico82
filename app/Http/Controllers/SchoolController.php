<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

use App\Imports\schoolsImport;
use App\Models\Variable;

class SchoolController extends Controller
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
        $query = School::orderBy('name', 'asc');
        $schools = $query->paginate();
        return view('schools.index',compact('schools'));
    }
    

    public function create()
    {
        return view('schools.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
        ]);


        $school = new School();
        $school->name = $request->name;
        $school->email = $request->email;
        $school->phone = $request->phone;
        
        $school->business_name = $request->business_name;
        $school->company = $request->company;
        $school->address = $request->address;
        
        $school->save();

        return redirect('schools')->with('success','Jardin de niños creado correctamente.');
    }

   

    public function edit($id)
    {
        $school = School::findOrFail($id);
        return view('schools.edit',compact('client'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
        ]);

        $school = School::findOrFail($id);

        $school->name = $request->name;
        $school->email = $request->email;
        $school->phone = $request->phone;
        
        $school->business_name = $request->business_name;
        $school->company = $request->company;
        $school->address = $request->address;
       
        $school->save();

        return redirect('schools')->with('success','Jardin de niños editado correctamente.');

    }

    public function destroy($id)
    {
        School::destroy($id);
        return redirect('schools')->with('success','Jardin de niños eliminado correctamente.');
    }

   

   
}
