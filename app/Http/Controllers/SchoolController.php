<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Mail;
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


        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 8; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $User = new User();
        $User->name = $request->responsible;
        $User->email = $request->email;
        $User->password = Hash::make($randomString);
        $User->userTypeId = 2;//Directora
        $User->schoolId = $school->id;
        $User->save();
        
        $destinatario = $User->email;
        $msg = "Ha sido invitad@ a colaborar en el sistema de Consejo Técnico 82. \n\n "  . 
                
        "Para ingresar al sistema ingrese a: " . env('APP_URL') . "\n" .
        "Su usario es: " . $User->email . " \n" . 
        "Contraseña temporal: " . $randomString;

        $data = [];

        try{
            Mail::send(['email'=>'xxx'],$data, function ($message) use ($destinatario, $msg) {
                $message->from('no-reply-ticket@consejotecnico82.com', 'Consejo Técnico 82');
                $message->to($destinatario);
                $message->subject('Bienvenido a Consejo Técnico 82');
                $message->setBody($msg);
            });
            
        } catch (\Throwable $th) {
        }



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
