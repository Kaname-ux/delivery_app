<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Client;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisteruserController extends Controller
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
    protected $redirectTo = '/dashboard';

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
            'name' => ['required', 'string', 'max:50'],
            'city' => ['required', 'string'],
            'adresse' => ['required', 'string', 'max:100'],
            
            'phone' => ['required', 'string', 'max:10', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:20', 'confirmed'],
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
         $client = new Client;

     
    
            $user = new User;

            $user->name = $data['name'];
            $user->phone = $data['phone'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->usertype = 'client';
           
            $user->approved  = 'yes';
            $user->category  = 1 ;
        // return User::create([
        //     'name' => $data['name'],
        //     'phone' => $data['phone'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password']),
        //     'usertype' => 'client',
        //     'client_id' => $client->id,
        //     'approved'  => 'yes',
        //     'category'  => 1
        // ]);


     $client->nom = $data['name'];
     $client->phone = $data['phone'];
     
     $client->city = $data['city'];
     $client->adresse = $data['adresse'];
          

    $user->save(); 
    $client->save();


      $user->client_id = $client->id;
      $client->user_id = $user->id; 

      $user->save();
      $client->save();
    
   return redirect()->back()->with('status', "Client Ajoutée");

    }

   
 
}
