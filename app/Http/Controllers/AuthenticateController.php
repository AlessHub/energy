<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticateController extends Controller
{
    public function index ()
    {
        $users = User::all();
        return  response($users,201);

    }
    
    
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:users|email|max:255',
            'password' => 'required|min:6'
        ]);

        $user=User::create([
            'name' =>$request->name,
            'email' => $request->email,
            'password' =>Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->accessToken;

        return Response([
            'token' => $token
        ]);

    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'The provided credentials are incorrect.',
            ]);
        } 
        else{

            $token = $user->createToken('auth_token')->accessToken;
            return response([
                'message' => 'success logged in',
                'token' => $token,
            ]);
        }

    }
    

    // login antiguo, lo dejo en caso de que al hacer merge se rompa, está actualizado para que los tests funcionen
    // correctamente, y no debería de dar ningun problema


    // public function login(Request $request)
    // {
    //     $request->validate([
            
    //         'email' => 'required',
    //         'password' => 'required'
    //     ]);

    //     $user = User::where('email', $request->email)->first();

    //     if(!$user|| !Hash::check($request->password,$user->password)) {
    //         return response([
    //             'message' => 'The provided credentials are incorrect.',
    //         ]);
    //     } else{
    //         return response([
    //             'message' => 'success logged in',
    //         ]);
    //     }
    //     $token = $user->createToken('auth_token')->accessToken;

    //     // return $user->createToken($request->device_name)->plainTextToken;
    //     return Response([
    //         'token' => $token,
    //     ]);
    // }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response([
            'message'=>'Logged out successfully'
        ]);
    }

    public function update(Request $request, $id)
    {
        $Comment=User::findOrFail($id);
        $Comment->update([
            'name' => $request->name,
            'password' => $request->password,
        ]);

        return response([
            'message'=>'Your data has been updated successfully'
        ],201);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user|| !Hash::check($request->password,$user->password)) {
            return response([
                'message' => 'The provided credentials are incorrect.',
            ]);
        } else{

            $request->user()->delete();

            return response([
            'message'=>'Deleted successfully'
            ]);
        }
    }

    public function validateToken(Request $request,$th)
    {
        try {
            $user = $request->user();
            return response(['isValid' => true, 'message' => 'valid token'], 200);
        } catch (\Throwable $th) {
            return response(['isValid' => false, 'message' => 'invalid token'], 401);
        }
    }
}
