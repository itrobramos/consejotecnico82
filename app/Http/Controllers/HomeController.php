<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Format;
use App\Models\SentFormat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->userTypeId == 1) //Admin
            return view('home');
        else { //Directora

            $oldformats = SentFormat::where('schoolId',Auth::user()->schoolId)->get();

            $ids= [];
            foreach($oldformats as $oldFormat){
                $ids[] = $oldFormat->formatId;
            }


            $formats = Format::where('beginDate', '<=', date('Y-m-d'))
                ->where('endDate', '>=', date('Y-m-d'))
                ->where('active', 1)
                ->whereNotIn('id',$ids)
                ->get();



            return view('directorHome', compact('formats', 'oldformats'));
        }
    }
}
