<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use JWTAuth;


class UserController extends Controller
{
    //

    public function created_user(Request $request){
        
        try {
            
           $user = new User([
            "name" => $request->user_name,
            "email" => $request->user_email,
            "password" => hash::make($request->password) 
           ]);
           $user->save();

            $success = true;
            $message = 'ບັນທຶກຂໍ້ມູນ ສຳເລັດ!';

        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);

    }

    public function login(Request $request){

        $user_login = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $token = JWTAuth::attempt($user_login); // ທຳການກວດຊອບ email ແລະ password, ຖ້າຖຶກຕ້ອງຈະສົ່ງ token ອອກມາ
        $user_data = Auth::user(); // ດຶງເອົາຂໍ້ມູນຜູ້ໃຊ້ ທີ່ login ສຳເລັດ

        if($token){
            $response = [
                'success' => true,
                'message' => 'ສຳເລັດ!',
                'user_data' => $user_data,
                'token' => $token
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'ອີເມວລ໌ ຫຼື ລະຫັດຜ່ານບໍ່ຖຶກຕ້ອງ!'
            ];
        }

        return response()->json($response);


        
    }
}
