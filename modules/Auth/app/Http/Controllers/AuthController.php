<?php

namespace Modules\Auth\Http\Controllers;

use Exception;
use Modules\User\Entities\User;
use Illuminate\Http\Request;
use Modules\Auth\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Modules\Auth\Http\Requests\GoogleSignInMobileRequest;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\Auth\Http\Requests\ResetPasswordRequest;
use Illuminate\Support\Facades\Validator;
use Modules\Auth\Http\Transformers\AuthUserResource;
use Modules\Common\Http\Controllers\BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;

/**
 * @group Auth
 */
class AuthController extends BaseController
{

    /**
     * Auth service
     * @var AuthService 
     */
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->middleware(['auth:sanctum'])->only(['revokeToken', 'getAuthenticatedUser']);
        $this->authService = $authService;
    }


    /**
     * Register with email & password
     * @param RegisterRequest $request
     * @return JsonResponse|Application|ResponseFactory
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user   = $this->authService->register($request);
            $token  = $user->createToken($user->email)->plainTextToken;
            return response()->json([
                'token'   => $token,
                'user'    => new AuthUserResource($user)
            ], JsonResponse::HTTP_CREATED);
        } catch (Exception $exception) {
            return response([
                'status' => false,
                'message' => $exception->getMessage()
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Login with email & password
     * @param LoginRequest $request
     * @return JsonResponse|Application|ResponseFactory
     */
    public function login(LoginRequest $request)
    {
        try {
            $user   = $this->authService->login($request);
            $token  = $user->createToken($user->email)->plainTextToken;
            return response()->json([
                'token'   => $token,
                'user'    => new AuthUserResource($user)
            ], JsonResponse::HTTP_OK);
        } catch (Exception $exception) {
            return response([
                'status' => false,
                'message' => $exception->getMessage()
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Google sign in mobile
     * @param GoogleSignInMobileRequest $request
     * @return JsonResponse|Application|ResponseFactory
     */
    public function googleSignInMobile(
        GoogleSignInMobileRequest $request
    ) {
        try {
            $user   = $this->authService->googleSignInMobile($request);
            $token  = $user->createToken($user->email)->plainTextToken;
            return response()->json([
                'token'   => $token,
                'user'    => new AuthUserResource($user)
            ], JsonResponse::HTTP_OK);
        } catch (Exception $exception) {
            return response([
                'status' => false,
                'message' => $exception->getMessage()
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Get authenticated user
     * @return JsonResponse|Application|ResponseFactory 
     */
    public function getAuthenticatedUser()
    {
        try {
            $user   = User::findOrFail(auth()->id());
            return new AuthUserResource($user);
        } catch (Exception $exception) {
            return response([
                'status' => false,
                'message' => $exception->getMessage()
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Check username
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse|Application|ResponseFactory  
     */
    public function checkUsername(Request $request)
    {
        $request->validate([
            'username'  => ['required', 'string'],
        ]);
        try {
            $userExist = User::where('username', $request->username)->first();
            if ($userExist) {
                return response()->json([
                    'isAvailable' => false
                ]);
            } else {
                return response()->json([
                    'isAvailable' => true
                ]);
            }
        } catch (Exception $exception) {
            return response([
                'status' => false,
                'message' => $exception->getMessage()
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Send reset password link.
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse|Application|ResponseFactory 
     */
    public function sendResetPasswordLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'appId' => ['required', 'string']
        ]);
        if ($validator->fails()) {
            return new JsonResponse(
                ['errors' => $validator->errors()],
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        try {
            $result = $this->authService->sendResetPasswordLink($request->email, $request->appId);
            return response()->json(['status' => true, 'message' => $result], JsonResponse::HTTP_OK);
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /** 
     * Verify token password reset.
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse|Application|ResponseFactory 
     */
    public function verifyTokenPasswordReset(
        Request $request
    ) {
        $request->validate(
            [
                'token'     => ['required', 'string'],
                'email'     => ['required', 'email', 'exists:users,email']
            ],
            [
                'token.required'     => ['Token is required'],
                'email.exists'       => ['Email not found'],
            ]
        );
        try {
            $result = $this->authService->verifyTokenPasswordReset($request->email, $request->token);
            return new AuthUserResource($result);
        } catch (Exception $exception) {
            return response([
                'status' => false,
                'message' => $exception->getMessage()
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Reset password
     * @param \Modules\Auth\Http\Requests\ResetPasswordRequest $request
     * @return JsonResponse|Application|ResponseFactory
     */
    public function resetPassword(
        ResetPasswordRequest $request
    ) {
        try {
            $user   = $this->authService->resetPassword($request);
            $token  = $user->createToken($user->email)->plainTextToken;
            return response()->json([
                'token'   => $token,
                'user'    => new AuthUserResource($user)
            ], JsonResponse::HTTP_OK);
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Revoke token from the database
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse|mixed
     */
    public function revokeToken(Request $request)
    {
        $request->validate(['currentAccessToken' => ['required', 'string']]);
        $result = $this->authService->deleteCurrentAccessToken($request->currentAccessToken);
        if ($result) {
            return response()->json([
                'message'   => 'Token has been delete!'
            ], JsonResponse::HTTP_OK);
        } else {
            return response()->json([
                'message'   => 'Failed to remove access token'
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}
