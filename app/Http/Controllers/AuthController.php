<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
    /**
     * Авторизация пользователя
     * 
     * @return JSON
     */
    public function auth(Request $req)
    {
        $status = 'error';

        $valid = Validator::make($req->all(), [
            'login'     => 'required',
            'password'  => 'required|min:8'
        ]);
        
        # Если данные не прошли валидацию
        if ( $valid->fails() ) { 
            return response()->json([
                'status'    => 'error',
                'type'      => 'validation',
                'message'   => $valid->errors()
            ]);
        }

        if( Auth::attempt(['email' => $req->login, 'password' => $req->password]) ) {
            $status = 'ok';
        }

        return response()->json([
            'status'    => $status,
            'type'      => 'auth',
            'message'   => ''
        ]);
    }

    /**
     * Выход из аккаунта
     */
    public function logout()
    {
        Auth::logout();
        return redirect('admin/login');
    }
}
