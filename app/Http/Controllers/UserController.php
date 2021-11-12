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
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        
        //si algo anda mal enviar un mensaje
        if($validator->fails()){
            return $validator->errors()->add('mensaje', 'Tienes errores de validacion');
        }
        
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        //crea el token en oauth_access_tokens
        $token =  $user->createToken('MyApp')->accessToken;
        $name =  $user->name;

        return response()->json([
            'name'      => $name,
            'token'     => $token,
            'message'   => 'Usuario creado con exito!'
        ], 201);
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)){
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
            

        //hace lo mismo que el otro solo que me da errores si importancia    
        //$user = Auth::user();
        $user = $request->user();
       
        $tokenResult = $user->createToken('Personal Access Token');
        
        $token = $tokenResult->token;
        if ($request->remember_me){        
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ]);
    }

    public function profile(Request $request)
    {
        $user = Auth::user();

        return response()->json([
            "profile" => $user
        ]);
        //return response()->json(compact('user'), 200); 
    }

    public function logout(Request $request){
       
        $token= $request->user()->token();
        $token->revoke();
        return response()->json([
            'message' => "tu seccion se cerro con exito!!"
        ]);
    }
}

