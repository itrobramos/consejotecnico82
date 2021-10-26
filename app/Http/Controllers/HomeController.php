<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Format;
use App\Models\School;
use App\Models\SentFormat;
use App\Models\SchoolFormat;
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
        if (Auth::user()->userTypeId == 1){ //Admin

            $formats = Format::where('beginDate', '<=', date('Y-m-d'))
                ->where('endDate', '>=', date('Y-m-d'))
                ->where('active', 1)
                ->get();

            $schoolFormats = SchoolFormat::where('ended',0)->get();
            $openFormats = SchoolFormat::where('ended',0)->get()->unique('formatId');

            $alcance = DB::select(' SELECT COUNT(*) count FROM schools_formats 
            WHERE formatId IN (
            SELECT distinct(formatId) FROM schools_formats
            where ended = 0)');

            $alcance = collect($alcance);
            $alcance = ($alcance[0]->count);



            $contestados = DB::select(' SELECT COUNT(*) count FROM schools_formats 
            WHERE formatId IN (
            SELECT distinct(formatId) FROM schools_formats
            where ended = 0)and
            ended = 1');

            $contestados = collect($contestados);
            $contestados = ($contestados[0]->count);

            return view('home', compact('formats', 'openFormats', 'alcance', 'contestados'));
        }
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
