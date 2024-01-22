<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Livreur;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/commencer';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:150'],
            'city' => ['required', 'string'],
            'adresse' => ['required', 'string', 'max:150'],
           
            'phone' => ['required', 'string', 'max:10', 'min:10'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = new User;
        $livreur = new Livreur;


            $user->name = $data['name'];
            $user->phone = $data['phone'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->usertype = 'livreur';
           
            
            
            



        // return User::create([
        //     'name' => $data['name'],
        //     'phone' => $data['phone'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password']),
        // ]);


    $livreur->nom = $data['name'];
     $livreur->phone = $data['phone'];
     
     $livreur->city = $data['city'];
     $livreur->adresse = $data['adresse'];
     $livreur->status  = 'active';  
        

    $user->save(); 
    $livreur->save();


      $user->livreur_id = $livreur->id;
      $livreur->user_id = $user->id; 

      $user->save();
      $livreur->save();  

      return $user;
    }
}
