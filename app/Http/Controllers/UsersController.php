<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * Получаем список пользователей
     * 
     * @return view
     */
   public function getUsers(Request $req)
   {
       $get = DB::table('users')->get();
       
       return view('admin.users.list', ['users' => $get]);
   }

   /**
     * Регистрация пользователя
     * 
     * @return JSON
     */
   public function addUser(Request $req)
   {
        $valid = Validator::make($req->all(), [
            'email'             => 'required|min:2',
            'role'              => 'required|numeric',
            'password'          => 'required',
            'passwordRepiat'    => 'required'
        ]);

        # Если данные не прошли валидацию
        if ( $valid->fails() ) { 
            return response()->json([
                'status'    => 'error',
                'type'      => 'validation',
                'message'   => $valid->errors()
            ]);
        }

        if ( $req->password != $req->passwordRepiat) {
            return response()->json([
                'status'    => 'error',
                'type'      => 'validation',
                'message'   => ['passwordRepiat' => 'Пароли не совпадают!']
            ]);
        }

        try {
            $user = new User();
            $user->role     = $req->role;
            $user->email    = $req->email;
            $user->password = Hash::make( $req->password );
            $user->save();

            return response()->json([
                'status'    => "ok",
                'message'   => ''
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status'    => "error",
                'type'      => 'add',
                'message'   => 'User already created.'
            ]);
        }
   }
}
