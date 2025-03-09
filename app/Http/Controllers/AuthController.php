<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $validated=$request->validate([
            'name'=>'required|string',
            'email'=>'required|email',
            'password'=>'required|string|min:8|confirmed',
            'user_photo'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:208'
        ]);
       $validated['password']=bcrypt($request->password); 
       
       if($request->hasFile('user_photo')){
            $filename = $request->file('user_photo')->store('user', 'public');
       } else {
            $filename=null;
       }
       $validated['user_photo']=$filename;
       $user = User::create($validated);
       $token = $user->createToken('auth_token')->plainTextToken;
       return response()->json([
            "message"=>"user registered successfully",
            "user"=>$user,
            "token"=>$token
       ], 201);
    }

    public function login(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|string'
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user || !\Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        // Check if user exists before creating token
        if ($user) {
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Logged in successfully',
                'user' => $user,
                'token' => $token,
            ], 201);
        }
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message'=>'logged out successfully',
        ], 201);
    }
}
