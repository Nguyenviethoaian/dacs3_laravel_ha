<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $data['name']= strstr($data['email'], '@', true);
        $user = User::create($data);
        $token = $user->createToken(User::USER_TOKEN);
        return $this->success([
            'user' => $user,
            'token'=> $token->plainTextToken,
        ], 'User created successfully');
    }
    /**
     * Validate user credential
     * @param LoginRequest $request
     * @return array
     */
    public function isValidCredential(LoginRequest $request):array{
        $data =$request->validated();
        $user = User::where('email',$data['email'])->first();
        if($user===null){
            return [
                'success'=>false,
                'message'=>'Invalid credentials'
            ];
        }
        if(Hash::check($data['password'], $user->password)){
            return [
                'success'=>true,
                'user'=> $user,
            ];
        }
        return [
            'success'=>false,
            'message'=>'Password is not matchted'
        ];
    }
    public function login(LoginRequest $request) : JsonResponse{
        $isValid = $this->isValidCredential($request);
        if(!$isValid['success']){
            return $this->error($isValid['message'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user= $isValid['user'];
        $token=$user->createToken(User::USER_TOKEN);
        return $this->success([
            'user'=> $user,
            'token'=> $token->plainTextToken,
        ],'Login successfully');

    }
    /**
     * Logins a user with token
     * 
     * @param JsonResponse
     */
    public function loginWithToken() :JsonResponse{
        return $this-> success(auth()->user(),'Login successfully');
    }

    /**
     * Logout a user
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request) : JsonResponse{
        $request->user()->currentAccessToken()->delete();
        return $this->success(null,'Logout successfully');
    }
}

