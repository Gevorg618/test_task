<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserRegisterResource;
use Illuminate\Http\JsonResponse;
use App\Contracts\UserInterface;
use Illuminate\Http\Response;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     *  User login
     *
     * @param  UserLoginRequest $userLoginRequest
     *
     * @return JsonResponse
     */
    public function login(UserLoginRequest $userLoginRequest) : JsonResponse
    {

        if (Auth::attempt($userLoginRequest->only(['email', 'password']))) {
            $authUser = auth()->user();
            $authUser->tokens()->delete();
            $authUser->token = $authUser->createToken('apiAuthToken')->plainTextToken;
            return UserRegisterResource::make($authUser)->response()->setStatusCode(Response::HTTP_CREATED);
        } else {
            return response()->json([
                'messages' => 'Not correct credentials',
            ], 401);
        }

    }

    /**
     *  User registration
     *
     * @param  UserRegisterRequest $userRegisterRequest
     * @param  UserInterface $userInterface
     *
     * @return JsonResponse
     */
    public function register(UserRegisterRequest $userRegisterRequest, UserInterface $userInterface) : JsonResponse
    {
        $createdUser = $userInterface->store([
           'name' => $userRegisterRequest->get('name'),
           'email' => $userRegisterRequest->get('email'),
           'password' => bcrypt($userRegisterRequest->get('password'))
        ]);

        $createdUser->token = $createdUser->createToken('apiAuthToken')->plainTextToken;

        return UserRegisterResource::make($createdUser)->response()->setStatusCode(Response::HTTP_CREATED);
    }
}
