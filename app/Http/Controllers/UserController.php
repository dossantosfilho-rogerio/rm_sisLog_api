<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    public function login(Request $request)
    {
        $request->validate([
            'cpf' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('cpf', $request->cpf)->first();
        
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'CPF e Senha não conferem'], 401);
        }

        return response()->json([
            'token' => $user->createToken('auth-token')->plainTextToken,
        ]);
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'cpf' => 'required',
            'password' => 'required',
        ]);

        
        $inputs = $request->all();
        $inputs['password'] = Hash::make($inputs['password']);
        $user = User::create($inputs);

        return response()->json($user);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logout realizado com sucesso']);
    }

}
