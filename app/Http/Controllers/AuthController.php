<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function register(Request $request) {

        $checkemail = count(User::where('email', $request->input('email'))->get());
        $checkphone_no = count(User::where('phone_no', $request->input('phone_no'))->get());
        
        if(strlen($request->input('email')) < 6) {
                return response()->json('Your Email Characters must be more than 6', 404);
            }
             elseif(strlen($request->input('name')) <3) {
                return response()->json('Name must be more than 3', 404);
            }
            elseif(strlen($request->input('phone_no')) <10) {
                return response()->json('Name must be more than 10', 404);
            } 
            else if ($checkemail > 0) {
             return response()->json('Email has been taken', 404);
            } 
            else if ($checkphone_no > 0) {
              return response()->json('Phone Number already taken', 404);
            } 
            elseif ($request->input('password') == '') {
                return response()->json('Password is empty', 404);
                } 
            elseif ($request->input('age') == '') {
                        return response()->json('Age is empty', 404);
              }  
            elseif ($request->input('role') == '') {
            return response()->json('Role is empty', 404);
            } 
            elseif ($request->input('password') != $request->input('password_again')) {
               return response()->json('Password doesnt match', 404);
            }
            else {
                $new = new User;
                $new->name = $request->input('name');
                $new->email = $request->input('email');
                $new->age = $request->input('age');
                $new->sex = $request->input('sex');
                $new->role = $request->input('role');
                $new->phone_no = $request->input('phone_no');
                $new->password = bcrypt($request->input('password'));

                $save = $new->save();
                if($save) {
                   // return response()->json('', 200);
                            $credentials = request(['email', 'password']);

                    if (! $token = auth()->attempt($credentials)) {
                        return response()->json(['error' => 'Unauthorized'], 401);
                    }

                    return $this->respondWithToken($token);

                } else {
                    return response()->json('error, please try again', 404);
                }
            }
        }
    
        
        public function resetPassword(Request $request) {
            $user = User::find(auth()->user()->id);
              $user->password = bcrypt($request->input('password'));
            $save = $user->save();
            if($save) {
                return response()->json('Password reset Successfully', 200);
            } else {
                return response()->json('Try again', 404);
            }
        } 
    
}
