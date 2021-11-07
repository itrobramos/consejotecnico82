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

            $openFormats = SchoolFormat::join('formats','formats.id', '=', 'schools_formats.formatId')
                                        //->where('ended',0)->get()->unique('formatId')
                                        ->where('beginDate', '<=', date('Y-m-d'))
                                        ->where('endDate', '>=', date('Y-m-d'))
                                        ->where('active', 1)
                                        ->get()->unique('formatId');
           
 
            $historicFormats = SchoolFormat::join('formats','formats.id', '=', 'schools_formats.formatId')
                                            ->where('ended',1)
                                            ->where('endDate', '<=', date('Y-m-d'))
                                            ->where('active', 1)
                                            ->get()->unique('formatId');



            $alcance = DB::select(' SELECT COUNT(*) count FROM schools_formats 
            WHERE formatId IN (
            SELECT distinct(id) FROM formats WHERE beginDate <= "' . date('Y-m-d') . '" AND  endDate >= "' . date('Y-m-d') . '")');

            $alcance = collect($alcance);
            $alcance = ($alcance[0]->count);

            $contestados = DB::select(' SELECT COUNT(*) count FROM schools_formats 
            WHERE formatId IN (
            SELECT distinct(id) FROM formats WHERE beginDate <= "' . date('Y-m-d') . '" AND  endDate >= "' . date('Y-m-d') . '")
            and ended = 1');

            $contestados = collect($contestados);
            $contestados = ($contestados[0]->count);

            return view('home', compact('historicFormats', 'openFormats', 'alcance', 'contestados'));
        }
        else { //Directora

            $oldformats = SentFormat::join('formats','formats.id', '=', 'sent_formats.formatId')
                                        ->join('schools_formats','schools_formats.formatId', '=', 'formats.id')                                                                                            
                                        ->where('schools_formats.schoolId',Auth::user()->schoolId)
                                        ->where('schools_formats.ended', 1)
                                        ->where('deleted_at', NULL)
                                        ->get();


            $ids= [];
            foreach($oldformats as $oldFormat){
                $ids[] = $oldFormat->formatId;
            }


            $formats = Format::join('schools_formats','schools_formats.formatId', '=', 'formats.id')       
                ->where('beginDate', '<=', date('Y-m-d'))
                ->where('endDate', '>=', date('Y-m-d'))
                ->where('schools_formats.schoolId',Auth::user()->schoolId)
                ->where('active', 1)
                ->whereNotIn('formats.id',$ids)
                ->get();


            return view('directorHome', compact('formats', 'oldformats'));
        }
    }
}
