<?php

namespace App\Swagger\controllersAnnotations\userAnnotations;

class AnnotationUser
{
    
    /**
     * @OA\Get(
     *      path="/players",
     *      operationId="getAllPlayers",
     *      tags={"Admins"},
     *      summary="Get all players. Requires admin role and valid token.",
     *      description="Get a list of all players. Requires admin role and valid token.",
     *      security={ {"bearerAuth": {} } },
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation. Returns a list of admins.",
     *
     *          @OA\JsonContent(
     *              type="array",
     *
     *              @OA\Items(
     *                  type="object",
     *
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="name", type="string", example="John"),
     *                  @OA\Property(property="surname", type="string", example="Doe"),
     *                  @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *
     *              )
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized. Token is missing or invalid."
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden. User does not have the necessary permissions (admin role)."
     *      ),
     * )
     */

    public function index(){}
       /**
     * @OA\Post(
     *      path="/login",
     *      operationId="login",
     *      tags={"Authentication"},
     *      summary="Login",
     *      description="Log in a user with their email and password.",
     *
     *      @OA\RequestBody(
     *          required=true,
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="email", type="string", format="email", example="player@example.com"),
     *              @OA\Property(property="password", type="string", format="password", example="secretpassword")
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful login",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="message", type="string", example="Logged in"),
     *              @OA\Property(property="user", type="string", example="John Doe"),
     *              @OA\Property(property="auth_token", type="string", example="eyJ0e...")
     *          )
     *      ),
     * @OA\Response(
     *          response=401,
     *          description="Unsuccessful login",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="message", type="string", example="Logged in"),
     *              @OA\Property(property="user", type="string", example="John Doe"),
     *          )
     *      ),
     *
     *     @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="errors", type="object", example={"email": {"The email field is required."}, "password": {"The password field is required."}})
     *          )
     *      ),
     *
     *
     *      ),
     * )
     */

    
public function login (){}
}