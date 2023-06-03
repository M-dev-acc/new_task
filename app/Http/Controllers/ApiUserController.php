<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterApiUserRequest;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiUserController extends Controller
{
    /**
     * Register api user
     * 
     * @param \App\Http\Requests\RegisterApiUserRequest $request
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterApiUserRequest $request)
    {
        $validatedInputs = $request->validated();

        try {
            $isUserCreated = User::create([
                'name' => $validatedInputs['name'],
                'email' => $validatedInputs['email'],
                'password' => Hash::make($validatedInputs['password']),
            ]);
        } catch (\Throwable $th) {
            throw new HttpResponseException(response()->json([
                'status' => false,
                'message' => "Something went wrong",
            ]));            
        }

        return response()->json([
            'status' => true,
            'message' => "User registerd successfully!",
            'user' => [
                'id' => $isUserCreated->id,
                'name' => $isUserCreated->user,
                'email' => $isUserCreated->email,
            ],
        ]);

    }
}
