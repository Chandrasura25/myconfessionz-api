<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Counselor;
use Illuminate\Support\Facades\Hash;


class AuthCounselorController extends Controller
{
    public function registerCounselor(Request $request){
        $request->validate([
            "username" => "required|string|unique:counselors,username",
            "firstName" => "required|string",
            "lastName"  => "required|string",
            "image" => "required",
            "counselingField" => "required|string",
            'password' => 'required|string|min:8',
            'dob' => 'required',
            'gender' => 'required',
            'country' => 'required',
            'state' => 'required',
            'recovery_question1' => 'required',
            'answer1' => 'required',
            'recovery_question2' => 'required',
            'answer2' => 'required',
            'recovery_question3' => 'required',
            'answer3' => 'required'
        ]);

        $formFields = ([
            "username" => $request->username,
            "first_name" => $request->firstName,
            "last_name" => $request->lastName,
            "counseling_field" => $request->counselingField,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'country' => $request->country,
            'state' => $request->state,
            'password' => bcrypt($request->password),
            'recovery_question1' => $request->recovery_question1,
            'answer1' => $request->answer1,
            'recovery_question2' => $request->recovery_question2,
            'answer2' => $request->answer2,
            'recovery_question3' => $request->recovery_question3,
            'answer3' => $request->answer3,
        ]);

        $newImageName = uniqid().'-'.'counselor'.'.'.$request->image->extension();
        $request->image->move(public_path('counselors'), $newImageName);

        $formFields['image'] = $newImageName;

        $counselor = Counselor::create($formFields);

        $token = $counselor->createToken('novit17')->plainTextToken;

        $response = [
            "message" => $counselor,
            "token" => $token
        ];

        return response()->json($response, 201);
    }

    public function loginCounselor(Request $request){
        $request->validate([
            "username" => "required",
            'password' => 'required',
        ]);

        // Check if counselor exists
        $counselor = Counselor::where('username', $request->username)->first();

        // Check password

        if(!$counselor || !Hash::check($request->password, $counselor->password)){
            $response = [
                'message' => 'Incorrect credentials'
            ];

            return response()->json($response, 401);
        }

        $token = $counselor->createToken('novit17')->plainTextToken;

        $response = [
            "message" => $counselor,
            "token" => $token
        ];

        return response()->json($response, 201);
    }

    public function logoutCounselor(Request $request){
        auth()->user()->tokens()->delete();

        $response = [
            'message' => 'Logged out'
        ];

        return response()->json($response, 200);
    }

    public function counselorPasswordResetRequest(Request $request){

        $request->validate([
            'username' => 'required',
        ]);

        $counselor = Counselor::where('username', $request->username)->first();

        if(!$counselor){
            $response = [
                "message" => "User does not exists"
            ];

            return response()->json($response, 401);
        }

        $token = $counselor->createToken('novit17')->plainTextToken;

        $response = [
            'message'=> 'Correct!',
            "token" => $token
        ];

        return response()->json($response, 200);
    }

    public function counselorPasswordRecoveryAnswer(Request $request){
        $request->validate([
            'username' => 'required',
            'recovery_question' => 'required',
            'answer' => 'required',
        ]);

        $counselor = Counselor::where('username', $request->username)->first();

        if(!$counselor){
            $response = [
                "message" => "Counselor does not exists"
            ];

            return response()->json($response, 401);
        }

        if(
            (($request->recovery_question == $counselor->recovery_question1) && ($request->answer == $counselor->answer1)) ||
            (($request->recovery_question == $counselor->recovery_question2) && ($request->answer == $counselor->answer2)) ||
            (($request->recovery_question == $counselor->recovery_question3) && ($request->answer == $counselor->answer3))
            ){
                return response()->json(["message" => "correct!"], 200);
            }
        return response()->json(["message" => "Recovery question and/or answer incorrect!"], 401);


    }
public function counselorPasswordReset(Request $request){
    $request->validate([
        'username' => 'required',
        'password' => 'required'
    ]);

    $counselor = Counselor::where('username', $request->username)->first();

    if(!$counselor){
        $response = [
            "message" => "Counselor does not exists"
        ];

        return response()->json($response, 401);
    }

    $password = bcrypt($request->password);

    Counselor::where('username', $request->username)->update(['password' => $password]);

    $response = [
        'message' => "password changed successfully!"
    ];

    return response()->json($response, 200);

}

    public function hello(){
        $res = auth()->user()->first_name;
        return response()->json($res, 201);
    }
}
