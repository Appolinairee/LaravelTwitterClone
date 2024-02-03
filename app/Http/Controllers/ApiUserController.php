<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use Carbon\Exceptions\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiUserController extends Controller
{
    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(CreateUserRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password, [
                    'rounds' => 12
                ]),
            ]);

            return response()->json([
                'statut_code' => 200,
                'statut_message' => 'Utilisateur enrégistré',
                'user' => $user
            ]);

            
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function login(LoginUserRequest $request){
        try {
            if(auth()->attempt($request->only(['email', 'password']))){
                $user = auth()->user();
                $token = $user->createToken('Invisible_Backend_Key')->plainTextToken;

                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Utilisateur connecté',
                    'user' => $user,
                    'token' => $token
                ]);
                
            }else{
                return response()->json([
                    'status_code' => 403,
                    'status_message' => 'Informations de connexion invalide'
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
