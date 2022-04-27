<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'min:1|required',
            'email' => ['email', 'unique:users'],
            'password' => ['min:4','max:8'],

        ]);

        //create user
        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->roles = $request->roles;
        $user->password = bcrypt($request->password);
        $user->profile = $request->profile;
        $user->student_id = $request->student_id;
        $user->save();

        //create token is a key can access to api
        // $token = $user->createToken('mytoken')->plainTextToken;

        return response()->json([
            'user' => $user,
            // 'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'User logout']);
    }
    
    public function login(Request $request)
    {
        //check email
        $user = User::where('email', $request->email)->first();

        //check password
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json(['message' => 'fail'], 401);
        }
        //create token is a key can access to api
        $token = $user->createToken('mytoken')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }
    public function index()
    {
        return User::with(['student'])->get();
    }
    
    public function show($id)
    {
        return User::with(['student'])->findOrFail($id);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'min:1|required',
            'email' => 'email',

        ]);
        //create user
        $user = User::findOrFail($id);
        $user->username = $request->username;
        $user->email = $request->email;
        $user->roles = $request->roles;
        $user->student_id = $request->student_id;
        $user->save();

        return response()->json(['message' => 'user updated!', "data" => $user], 200);
    }
    public function destroy($id)
    {
        return User::destroy($id);
    }

    
}
