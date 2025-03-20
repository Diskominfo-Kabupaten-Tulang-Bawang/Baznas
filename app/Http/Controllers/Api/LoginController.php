<?php

namespace App\Http\Controllers\Api;

use App\Models\Muzakki;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * login
     *
     * @param  mixed $request
     * @return void
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $muzakki = Muzakki::where('email', $request->email)->first();

        $passwordInfo = password_get_info($request->password);
        if ($passwordInfo['algo'] === null) {
            $password = Hash::make($request->password);
            if(!$muzakki) {
                $muzakki = Muzakki::create([
                    'name'      => $request->name ?? 'Muzakki',
                    'email'     => $request->email,
                    'password'  => $password,
                ]);
            }
    
            if (!Hash::check($request->password, $muzakki->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password salah!',
                ], 401);
            }
        } else { 
            if(!$muzakki) {
                $muzakki = Muzakki::create([
                    'name'      => $request->name ?? 'Muzakki',
                    'email'     => $request->email,
                    'password'  => $request->password,
                ]);
            }
    
            if ($request->password !== $muzakki->password) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password salah!',
                ], 401);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Login Berhasil!',
            'data'    => $muzakki,
            'token'   => $muzakki->createToken('authToken')->accessToken    
        ], 200);
    }
    
    /**
     * logout
     *
     * @param  mixed $request
     * @return void
     */
    public function logout(Request $request)
    {
        $removeToken = $request->user()->tokens()->delete();

        if($removeToken) {
            return response()->json([
                'success' => true,
                'message' => 'Logout Berhasil!',  
            ]);
        }
    }
}
