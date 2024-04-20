<?php

namespace App\Http\Controllers;

use App\Helpers\HelpersController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $helpersController;

    public function __construct(HelpersController $helpersController)
    {
        $this->helpersController  = $helpersController;
    }

    function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->helpersController->responseWithFailApiMsg('Bad request  | ' . str_replace('.', '', implode(', ', collect($validator->errors()->toArray())->map(function ($value) {
                    return implode(', ', $value);
                })->toArray())) . '.', 400);
            }

            // Verificamos que exista el usuario con la credenciales email y password recibidas por el request 
            if (!Auth::attempt($request->only(['email', 'password']))) {
                return $this->helpersController->responseWithFailApiMsg('Unauthorize', 401);
            }

            $user = User::where('email', $request->email)->first();

            // Creamos el token nuevo
            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->helpersController->responseSuccessApi([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user_name' => $user->name,
            ]);
        } catch (\Exception $e) {
            report($e);
            return $this->helpersController->respondWithInternalServerError();
        }
    }

    function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:5',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8'
            ]);

            if ($validator->fails()) {
                return $this->helpersController->responseWithFailApiMsg('Bad request  | ' . str_replace('.', '', implode(', ', collect($validator->errors()->toArray())->map(function ($value) {
                    return implode(', ', $value);
                })->toArray())) . '.', 400);
            }

            if (!$user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ])) {
                return $this->helpersController->responseWithFailApiMsg('Error al crear al usuario');
            }

            //Creacion del token para el usuario nuevo
            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->helpersController->responseSuccessApi([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user_name' => $user->name,
            ]);
        } catch (\Exception $e) {
            report($e);
            return $this->helpersController->respondWithInternalServerError();
        }
    }
}
