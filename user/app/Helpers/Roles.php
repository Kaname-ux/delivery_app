<?php
namespace App\Helpers;
use App\Role;
class Roles
{
	public function checkrole($antity, $client_type){
       $roles = Role::where("client_type", $client_type)
                   ->where('antity', $antity)
                   ->where('switch', 1)
                   ->get();

       return $roles;            
	}

	
}