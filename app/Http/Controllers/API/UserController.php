<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Rules\Password;

class UserController extends Controller
{
    public function login(Request $request)
    {
        try {
            //Validate Request
            $request->validate([
                'email' => 'request|email',
                'password' => 'required',
            ]);

            //Find by Email
            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error('Unauthorized', 401);
            }

            //Find user by Email
            $user = User::where('email', $request->email)->first();
            if (!Hash::check($request->password, $user - password)) {
                throw new Exception('Invalid Password');
            }

            //Generate token
            $TokenResult = $user->createToken('authToken')->plainTextToken;

            // return Response
            return ResponseFormatter::success(
                [
                    'access_token' => $TokenResult,
                    'token_type' => 'Bearer',
                    'user' => $user,
                ],
                'Login Success'
            );

            // TODO : Return Response
        } catch (Exception $e) {
            return ResponseFormatter::error('Authentication Failed');
        }
    }

    public function register(Request $request)
    {
        try {
            // validate request
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    'unique:users',
                ],
                'password' => ['required', 'string', new Password()],
            ]);

            // Create User
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Generate Token
            $TokenResult = $user->createToken('authToken')->plainTextToken;

            // return Response
            return ResponseFormatter::success(
                [
                    'access_token' => $TokenResult,
                    'token_type' => 'Bearer',
                    'user' => $user,
                ],
                'Register Success'
            );
        } catch (Exception $error) {
            // return error response
            return ResponseFormatter::error($error->getMessage());
        }
    }

    public function logout(Request $request)
    {
        $token = $request
            ->user()
            ->currentAccessToken()
            ->delete();

        return ResponseFormatter::success($token, 'Logout success');
    }

    public function fetch(Request $request)
    {
        $user = $request->user();

        return ResponseFormatter::success($user, 'FetchSuccess');
    }
}