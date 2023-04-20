<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;//El método Hash es para encriptar la contraseña
use App\Models\User;//Acceder al archivo de los datos del usuario


class usersController extends Controller
{
    public function showById($id){
        $user = User::find($id);
        return response()->json(["data"=>$user]);
      }    
      
}
