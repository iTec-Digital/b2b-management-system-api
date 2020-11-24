<?php


namespace App\GraphQL\Queries\Logout;


use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Tymon\JWTAuth\Facades\JWTAuth;

class Logout extends Query
{
    protected $attributes = [
        'name' => 'Logout',
        'description' => 'Logout the current user session!',
    ];

    public function type(): Type
    {
        return GraphQL::type('JsonResponse');
    }

    public function args(): array
    {
        return [

        ];
    }

    public function resolve($root, $args)
    {
        $token = request()->header('Authorization');

        if(JWTAuth::parseToken()->invalidate($token)) {
            return [
                'success' => true,
                'error_code' => null,
                'message' => 'Successfully logged out!',
            ];
        }

        return [
            'success' => false,
            'error_code' => 'JWT_ERROR',
            'message' => 'Failed to logout!',
        ];
    }
}
