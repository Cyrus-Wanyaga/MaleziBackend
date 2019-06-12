<?php

namespace App\Http\Controllers;

use App\Article;
use App\Child;
use App\ParentDetail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AndroidController extends Controller
{
    //
    public function RegisterChild(Request $request){

        $data = new Child();
        $data->name = $request['name'];
        $data ->parentId = $request['parentId'];
        $data->dateOfBirth = $request['dateOfBirth'];
        $data->gender = $request['gender'];
        $data->age = $request['age'];



        if ($data->save()){
            $response = array(
                'error' => false,
                'error_msg' => 'Child Registered'
            );
        } else{

            $response = array(
                'error' => true,
                'error_msg' => 'Child Not Registered'
            );

        }

        return json_encode( $response);
    }

    public function ParentSignUp(Request $request){

        $this->validate($request, [
            'email' => 'email|required|unique:users',
            'password' => 'required',
            'name' => 'required',
            'phone' =>'required|unique',
            'idNumber'=>'required|unique',
            'careGiverLevel' => 'required']);

        $data = ParentDetail::query()
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
                'password' => bcrypt($request->input('password')),
                'phoneNumber' => $request->input('phoneNumber'),
                'idNumber' => $request->input('idNumber'),
                'careGiverLevel'=>$request->input('careGiverLevel')
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

    public function ParentLogIn(Request $request){

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

    public function PostArticle(Request $request){
        //

        $data = new Article();
        $data -> title =$request['title'];
        $data -> tagId =$request['tagId'];
        $data -> shortTitle =$request['shortTitle'];
        $data -> text =$request['text'];
        $data -> picture = $request['picture'];

        if ($data->save()){
            $response = array(
                'error' => false,
                'error_msg' => 'Article Saved'
            );
        } else{

            $response = array(
                'error' => false,
                'error_msg' => 'Article Not Saved'
            );

        }
        return json_encode($response);

    }

    public function GetArticles(){

        $data = Article::all();

        if ($data != null){
             $response = $data;

        } else{
            $response = array(
                'error' => True,
                'error_msg' => 'No Articles Available'
            );
        }

        return json_encode($response);

    }



}
