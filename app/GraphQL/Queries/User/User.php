<?php

namespace App\GraphQL\Queries\User;

use Exception;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\DB;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;


class User extends Query
{
    protected $attributes = [
        'name' => 'User',
        'description' => 'Get User Profile Information',
    ];

    public function type(): Type
    {
        return GraphQL::type('UserResponse');
    }

    public function args(): array
    {
        return [
            'id' => ['type' => Type::id(), 'description' => 'Id of the user'],
            'email' => ['type' => Type::string(), 'description' => 'Email of the user'],
        ];
    }

    public function resolve($root, $args)
    {
        $auth_user = auth()->user();

        $sql = "SELECT * FROM users ";
        if (isset($args['id']) && (int)$args['id'] !== 0) {
            $user_id = (int)$args['id'];

            $sql .= "WHERE id = '{$user_id}'";
        } elseif (isset($args['email']) && trim($args['email']) !== '') {
            $user_email = $args['email'];

            $sql .= "WHERE email = '{$user_email}'";
        } else {
            $user_id = $auth_user->id;

            $sql .= "WHERE id = '{$user_id}'";
        }


        try {
            $user_detail = DB::select($sql);

            if(count($user_detail) > 0) {

                $user = $user_detail[0];
                unset($user->password);

                return [
                    'success' => true,
                    'error_code' => null,
                    'message' => 'User information fetched successfully!',
                    'data' => $user,
                ];
            } else {
                return [
                    'success' => true,
                    'error_code' => 'USER_NOT_FOUND',
                    'message' => 'The user you expected was not found!',
                ];
            }
        }
        catch (Exception $e) {
            return [
                'success' => false,
                'error_code' => 'DB_ERROR',
                'message' => 'Failed to fetch the user information! ' . $e->getMessage(),
            ];
        }
    }
}
