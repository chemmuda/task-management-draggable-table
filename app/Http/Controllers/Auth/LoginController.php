<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        // Display login form
        return $this->showLoginForm();
    }

    public function showLoginForm()
    {
        $data['title'] = 'Login';
        return view('auth.login',$data);
    }

    public function accountAuth(Request $request)
    {
        //Validate login form
        $validator = Validator::make(request()->all(),[
            'email' =>'required|email',
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            $response = array('msg' =>  $validator->errors());
            echo json_encode($response);
            die();
        }

        // Attempt to authenticate user using provided credentials
        $credentials = request()->only('email', 'password');

        if (Auth::attempt($credentials)) {
            request()->session()->regenerate();
            // Prepare the response
            $response = [
                'msg' => 'YES',
                'url' => env('APP_URL').'/v1/dashboard'
            ];
            // Send the JSON response
            return response()->json($response);
        }

        $response = array('msg' =>  'NO', 'msgYacho' => 'The provided credentials do not match our records.');
        echo json_encode($response);
        die();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
