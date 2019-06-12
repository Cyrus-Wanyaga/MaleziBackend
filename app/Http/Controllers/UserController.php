<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //

    public function postSignUp(Request $request)
    {

        $this->validate($request, [
            'email' => 'email|required|unique:users',
            'password' => 'required']);

         $data = User::query()
             ->where('email', '=', $request['email'])
             ->first();

         if ($data){
             $response = array(
                 'error' => true,
                 'error_msg' => 'User Exists'
             );
         } else{

             $user = new User([
                 'name' => $request->input('name'),
                 'email' => $request->input('email'),
                 'password' => bcrypt($request->input('password'))
             ]);

             if ($user->save()){

                 $response = array(
                     'error' => false,
                     'error_msg' => 'Success'
                 );
             } else{
                 $response = array(
                     'error' => true,
                     'error_msg' => 'Something Went Wrong'
                 );

             }

         }
        return json_encode($response);

    }


    public function Login(Request $request){

        //login logic

        //check if fields are empty

        $this->validate($request, [
            'email' => 'email|required|',
            'password' => 'required']);

        $data = User::query()
            ->where('email', '=', $request['email'])
            ->first();

        if ($data){
            if (Auth::attempt(['email' => $request->input('email'), 'password' =>
        $request->input('password')])){



                $response = array(
                    'error' => false,
                    'error_msg' => 'Welcome'
                );

            }else{
                $response = array(
                    'error' => true,
                    'error_msg' => 'Wrong Credentials'
                );
            }
        }else{
            $response = array(
                'error' => true,
                'error_msg' => 'User Does not Exists'
            );
        }


        return json_encode($response);

    }

}
