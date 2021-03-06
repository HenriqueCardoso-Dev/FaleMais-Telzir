<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //

    public function store(UserRequest $request) {
        try {
            $input = $request->validated();

            $verify = User::where('email', $input['email'])->first();

            if($verify) {
                return response()->json(['error' => 'Este e-mail já está sendo utilizado!'], 401);
            }

            DB::beginTransaction();

                $user = User::create([
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'password' => Hash::make($input['password']),
                    'user_flag' => 2
                ]);
            DB::commit();
            return $user;

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
