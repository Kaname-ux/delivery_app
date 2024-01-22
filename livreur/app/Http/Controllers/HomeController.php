<?php

namespace App\Http\Controllers;

use App\User;
use App\Livreur;
use App\Certification;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;
use Auth;
use DateTime;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Http\Request;

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

        $livreur = "";
        $current = "";
        if(auth::user()->usertype == "livreur")
       {$livreur = Livreur::findOrFail(Auth::user()->livreur_id);
             $current = Certification::where('livreur_id',$livreur->id)->latest()->first();}

  return view("certification")->with("livreur", $livreur)->with("current", $current);
    }
}
