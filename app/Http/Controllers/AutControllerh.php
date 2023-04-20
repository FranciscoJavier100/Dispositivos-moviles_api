<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;//El método Hash es para encriptar la contraseña
use App\Models\User;//Acceder al archivo de los datos del usuario
use Illuminate\Support\Facades\Auth; //Es para utilizar una librería de Laravel para la autentificación


class AutControllerh extends Controller
{
    //Se programan las funciones para el registro
    public function register(Request $request){//Se declara la funcion y se llama al parámetro de Request
        $data = $request -> json() -> all(); //Se obtienen los datos del formato request en un json
        $itExistUserName=User::where('email', $data['email'])->first();
        //Si el campo de enmail no está vacío el campo.
        if($itExistUserName == null){//Si el usuario es nulo
            $user = User::create( //Se va a crear un usuario con nombre, email y password
                [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password'])//Se encripta la contraseña del usuario
                ]
            );
            //Es necesario un identificador y a cada usuario que se va a crear se asigna un token.
            $token = $user ->createToken('web')->plainTextToken;//Identificador de usuario
            return response()->json([
                'data' => $user,
                'token' => $token
            ],200);

        }else{
             //Si el usuario intenta registrarse con otro que ya existe se le notifica
            return response()->json([ 
                'data' => 'User allready exist',
                'status' => false
            ],200);
        }
    }

// funcion de login el reques es el objeto que manda el usuario
public function login(Request $request){
    if(!Auth::attempt($request->only('email','password'))){
    return response()->json([
        'message'=> 'Correo o contraseña incorrectos',
        'status'=> false
    ],400);
}
     $user = User::where('email',$request['email'])->firstOrFail();
     $token = $user->createToken('web')->plainTextToken;
     return response()->json([

        'data'=> $user,
        'token'=>$token
     ]);
   }

//funcion de salir del usuario 
   public function logout(Request $request){
    $request->user() ->currentAccesToken->delete;
    return response->json ([
        'status'=>true,
    ]);
}
// funcion que cambia las contraseñas si al usuario se les llegase a perder o olvidar
public function newPassword($email){
    //verificamos que el email si le corresponda a un usuario
    $usuario = User::where('email', $email)->first();
    //Si no encuentra ningun usuario con ese email nos dira que no existe
    if (!$usuario) 
    {
    return response()->json(['message' => 'El usuario no existe'], 200);
    }else{
        // Generar una contraseña aleatoria de 6 caracteres
    $nuevaPassword = Str::random(6);
    // Actualizar el campo password de la tabla user
    $usuario->password = Hash::make($nuevaPassword);
    //guarda los cambios en la bd
    $usuario->save();
    // Enviar respuesta un mensaje, la nueva contraseña y el usuario al que se le hizo el cambio
    return response()->json([
        'mensaje' => 'Contraseña actualizada',
        'nuevaPassword' => $nuevaPassword,
    ], 200);
    }}}