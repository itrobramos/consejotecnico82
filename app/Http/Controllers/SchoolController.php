<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;

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
        return view('schools.add');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
        ]);


        $school = new School();
        $school->name = $request->name;
        $school->address = $request->address;
        $school->phone = $request->phone;
        $school->responsible = $request->responsible;
        $school->email = $request->email;
        $school->active = true;
        
        $school->save();

        $User = new User();
        $User->name = $request->responsible;
        $User->email = $request->email;
        $User->password = Hash::make('123123123');
        $User->userTypeId = 2;//Directora
        $User->schoolId = $school->id;
        $User->save();
        

        return redirect('schools')->with('success','Jardin de niños creado correctamente.');
    }

   

    public function edit($id)
    {
        $school = School::findOrFail($id);
        return view('schools.edit',compact('school'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
        ]);

        $school = School::findOrFail($id);

        $school->name = $request->name;
        $school->address = $request->address;
        $school->phone = $request->phone;
        $school->responsible = $request->responsible;
        $school->email = $request->email;
        $school->active = true;
       
        $school->save();

        $User = User::where('schoolId', $school->id)->first();
        $User->name = $request->responsible;
        $User->email = $request->email;
        $User->save();

        return redirect('schools')->with('success','Jardin de niños editado correctamente.');

    }

    public function destroy($id)
    {
        School::destroy($id);
        return redirect('schools')->with('success','Jardin de niños eliminado correctamente.');
    }

   

   
}
