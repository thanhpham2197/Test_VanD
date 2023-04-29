<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Repository\Interface\UserRepositoryInterface;
use App\Trait\ApiResponse;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Token;

class UserConctroller extends Controller
{
    use ApiResponse;

    private $userRepository;

    /**
     * Constructor of class
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Register by email
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function register(RegisterRequest $request)
    {
        $user = [
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ];

        try {
            $createdUser = $this->userRepository->register($user);

            $success = [
                'access_token' => $createdUser->createToken('API_TOKEN')->accessToken,
            ];

            return $this->successReponse($success, HttpResponse::HTTP_OK);
        } catch (\Exception $e) {
            return $this->errorResponse($e, HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * User login with email
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function login(LoginRequest $request)
    {
        $param = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if(Auth::attempt($param)) {
            $user = Auth::user();
            $response = [
                'access_token' => $user->createToken('API_TOKEN')->accessToken
            ];
            return $this->successReponse($response);
        } else {
           return  $this->errorResponse('Login fail', HttpResponse::HTTP_FORBIDDEN);
        }

    }

    /**
     * User logout
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function logout()
    {
        try {
            $user = auth('api')->user();
            if($user) {
                $tokens = Token::where('user_id', $user->id)->get();
                foreach($tokens as $token) {
                    $token->revoke();
                }
            }
            return $this->successReponse();
        } catch (\Exception $exception) {
            return $this->errorResponse($exception, HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
