<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
//Para utilixar validator
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register( Request $request){
        
        //validar registro
        $validator = Validator::make($request->all(),[
            'name'          => 'required',
            'telefono'      => 'required',
            'email'         => 'required|email',
            'empresa'       => 'required',
            'password'      => 'required',
            'c_password'    => 'required|same:password',
        ]);

        //return $request['email'];
        $regitrado = User::where('email',$request['email'])->first();
        if($regitrado !=null){
            $returnData = array(
                'status' => 'error',
                'message' => 'Ese nombre de email ya está en uso. Prueba con otro.'
            );
            return response()->json($returnData, 400);
        }
        


        //si algo anda mal enviar un mensaje
        if($validator->fails()){
            return $validator->errors()->add('mensaje', 'Tienes errores de validacion');
        }


        
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        //crea el token en oauth_access_tokens
        $token =  $user->createToken('MyApp')->accessToken;
        $user =  $user;

        return response()->json([
            'user'          => $user,
            'access_token'  => $token,
            'message'       => 'Usuario creado con exito!'
        ], 201);
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)){
            return response()->json([
                'message' => 'Email o contraseña incorrecta. Vuelve a intentarlo o selecciona "¿Has olvidado tu contraseña?" para cambiarla.'
            ], 401);
        }
            

        //hace lo mismo que el otro solo que me da errores sin importancia    
        //$user = Auth::user();
        $user = $request->user();
       
        $tokenResult = $user->createToken('Personal Access Token');
        
        $token = $tokenResult->token;
        if ($request->remember_me){        
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        $token->save();

        return response()->json([
            'user'          => $user,
            'access_token'  => $tokenResult->accessToken,
            'token_type'    => 'Bearer',
            'expires_at'    => Carbon::parse($token->expires_at)->toDateTimeString()
        ]);
    }

    public function user(Request $request)
    {
        $user = Auth::user();

        return response()->json([
            "profile" => $user
        ]);
        //return response()->json(compact('user'), 200); 
    }

    public function logout(Request $request){

        //return $request->user()->token();
        $token= $request->user()->token();
        $token->revoke();
        return response()->json([
            'message' => "tu seccion se cerro con exito!!"
        ]);
    }
}

