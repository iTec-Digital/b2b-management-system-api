<?php

namespace App\GraphQL\Queries\Login;

use App\Core\Classes\BRANCH\BRANCH;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\Type;
use Tymon\JWTAuth\Facades\JWTAuth;

class Login extends Query
{
    protected $attributes = [
        'name' => 'Login',
        'description' => 'Make authentication to the system',
    ];

    public function type(): Type
    {
        return GraphQL::type('LoginResponse');
    }

    public function args(): array
    {
        return [
            'Email' => ['type' => Type::string(), 'description' => 'Email address of the user', 'rules' => 'required'],
            'Password' => ['type' => Type::string(), 'description' => 'Password of the user', 'rules' => 'required'],
        ];
    }

    public function resolve($root, $args)
    {
        $Email = $args['Email'];
        $Password = $args['Password'];

        $credentials = [
            'email' => $Email,
            'password' => $Password,
        ];

        //Try authenticating
        if (!$token = auth()->attempt($credentials)) {
            return [
                'success' => false,
                'error_code' => 401,
                'message' => 'Your email or password was incorrect!',
            ];
        }



        //Check some information
        $auth_user = auth()->user();
        if($auth_user->IsActive == 0) {
            return [
                'success' => false,
                'error_code' => 'ACCOUNT_BANNED',
                'message' => 'Your account has been banned! Please contact the administrator!',
            ];
        }

        if($auth_user->IsDeleted == 1) {
            return [
                'success' => false,
                'error_code' => 'ACCOUNT_DELETED',
                'message' => 'Your account was deleted by the administrator!',
            ];
        }



        /**
         * Remove the previously logged branch id from the database
         * For re-logging a branch at startup
         */
        BRANCH::SWITCH_ID(0);

        return [
            'success' => true,
            'error_code' => null,
            'token' => $token,
            'message' => 'Successfully logged in!',
        ];
    }
}
