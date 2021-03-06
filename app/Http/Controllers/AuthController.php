<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;
use Validator;

class AuthController extends Controller
{
    public function register()
    {
        /**
         * @TODO:: Implement JWT later.
         */
        $validator = Validator::make(request()->all(), [
            'name'=>'required', 
            'email'=>'required | email | unique:users', 
            'password'=> 'required | confirmed', 
            'password_confirmation'=> 'required'
            ]);

            if ($validator->fails()) {
                return $this->customResponse('400', 'Validation Failed.', $validator->errors());
            }
            $user = User::create([
                'name'=>request()->name,
                'email'=>request()->email,
                'password'=>bcrypt(request()->password)
            ]);
            $user->update(['api_token' => str_random (60)]); // Move this to above query, dont be lazy.
            if (!$user) {
            return $this->customResponse('500', 'User not created. Something went wrong.');
            }
            return $this->customResponse('200', 'User created Successfully.', $user);

    }

    public function login()
    {
        $user = User::where('email', request()->email)->first();
        if (!$user) {
            Log::info('User not found', ['details'=> request()->all()];
            return $this->customResponse('400', 'Invalid Credentials');
        }
        if (!Hash::check(request()->password,  $user->password)) {
            Log::info('passwords do not match', ['details'=> request()->all()];
            return $this->customResponse('400', 'Invalid Credentials');
        }
        $user->update(['api_token'=>str_random(60)]);
        return $this->customResponse('200', 'User logged in Successfully', $user);
    }


    public function logout()
    {
        $user = User::where('api_token', request()->api_token)->first();
       
        $user->update(['api_token' => null]);
        return $this->customResponse('200', 'User logged out Successfully');
    }




    public function customResponse($code, $message = null, $data = [])
    {
        return response()->json([
            'responseMessage' => $message ?? '',
            'responseCode' => $code ?? '',
            'data' => $data ?? []
        ], 200);
    }
}
