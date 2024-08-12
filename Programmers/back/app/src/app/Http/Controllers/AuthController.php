<?php

namespace App\Http\Controllers;

use App\Events\UserSignedUp;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\SignupRequest;
use App\Http\Resources\LoggedInUserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response;
use OpenApi\Attributes as OAT;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthController extends Controller
{
<<<<<<< HEAD
    /**
     * Create a new controller instance.
     *
     * @param  AuthService  $authService
     * @return void
     */
=======

>>>>>>> b75655ec499b2dbbe13cb7ef96f6c849490a6d43
    public function __construct(private AuthService $authService)
    {
        //
    }

<<<<<<< HEAD
    /**
     * Signup a user.
     *
     * @param  SignupRequest  $request
     * @return JsonResponse
     */
    #[OAT\Post(
        tags: ['auth'],
        path: '/api/signup',
        summary: 'Signup a user',
        operationId: 'AuthController.signup',
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(ref: '#/components/schemas/SignupRequest')

        ),
        responses: [
            new OAT\Response(
                response: HttpResponse::HTTP_CREATED,
                description: 'Created',
                content: new OAT\JsonContent(ref: '#/components/schemas/LoggedInUserResource')
            ),
            new OAT\Response(
                response: HttpResponse::HTTP_UNPROCESSABLE_ENTITY,
                description: 'Unprocessable entity',
                content: new OAT\JsonContent(ref: '#/components/schemas/ValidationError')
            ),
        ]
    )]
=======

>>>>>>> b75655ec499b2dbbe13cb7ef96f6c849490a6d43
    public function signup(SignupRequest $request): JsonResponse
    {
        $user = $this->authService->signupUser($request);

        UserSignedUp::dispatch($user);

        return Response::json(new LoggedInUserResource($user), HttpResponse::HTTP_CREATED);
    }

<<<<<<< HEAD
    /**
     * Login a user.
     *
     * @param  LoginRequest  $request
     * @return JsonResponse
     *
     * @throws HttpException
     * @throws NotFoundHttpException
     */
    #[OAT\Post(
        tags: ['auth'],
        path: '/api/login',
        summary: 'Login a user',
        operationId: 'AuthController.login',
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(ref: '#/components/schemas/LoginRequest')

        ),
        responses: [
            new OAT\Response(
                response: HttpResponse::HTTP_OK,
                description: 'Ok',
                content: new OAT\JsonContent(ref: '#/components/schemas/LoggedInUserResource')
            ),
            new OAT\Response(
                response: HttpResponse::HTTP_UNPROCESSABLE_ENTITY,
                description: 'Unprocessable entity',
                content: new OAT\JsonContent(ref: '#/components/schemas/ValidationError')
            ),
            new OAT\Response(
                response: HttpResponse::HTTP_UNAUTHORIZED,
                description: 'Unauthorized',
                content: new OAT\JsonContent(
                    properties: [
                        new OAT\Property(
                            property: 'message',
                            type: 'string',
                            example: 'Invalid credentials.'
                        ),
                    ]
                )
            ),
        ]
    )]
=======

>>>>>>> b75655ec499b2dbbe13cb7ef96f6c849490a6d43
    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->authService->loginUser($request);

        return Response::json(new LoggedInUserResource($user));
    }

<<<<<<< HEAD
    /**
     * Logout a user.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    #[OAT\Post(
        tags: ['auth'],
        path: '/api/logout',
        summary: 'Logout a user',
        operationId: 'AuthController.logout',
        security: [['BearerToken' => []]],
        responses: [
            new OAT\Response(
                response: HttpResponse::HTTP_NO_CONTENT,
                description: 'No content'
            ),
        ]
    )]
=======
>>>>>>> b75655ec499b2dbbe13cb7ef96f6c849490a6d43
    public function logout(Request $request): JsonResponse
    {
        $this->authService->logoutUser($request->user());

        return Response::json(null, HttpResponse::HTTP_NO_CONTENT);
    }
<<<<<<< HEAD
=======

>>>>>>> b75655ec499b2dbbe13cb7ef96f6c849490a6d43
}
