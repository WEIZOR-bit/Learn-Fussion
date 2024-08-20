<?php

namespace App\Http\Controllers;

use App\Events\UserSignedUp;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\SignupRequest;
use App\Http\Resources\LoggedInUserResource;
use App\Services\AuthService;
use App\Services\CourseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response;
use OpenApi\Attributes as OAT;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @param AuthService $authService
     * @return void
     */

    public function __construct(private AuthService $authService, private CourseService $courseService)
    {
        //
    }

    /**
     * Signup a user.
     *
     * @param SignupRequest $request
     * @return JsonResponse
     */

    public function signup(SignupRequest $request): JsonResponse
    {
        $user = $this->authService->signupUser($request);

        UserSignedUp::dispatch($user);

        return Response::json(new LoggedInUserResource($user), HttpResponse::HTTP_CREATED);
    }

    /**
     * Login a user.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     *
     * @throws HttpException
     * @throws NotFoundHttpException
     */

    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->authService->loginUser($request);

        return Response::json(new LoggedInUserResource($user));
    }

    /**
     * Logout a user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $this->authService->logoutUser($request->user());

        return Response::json(null, HttpResponse::HTTP_NO_CONTENT);
    }
}
