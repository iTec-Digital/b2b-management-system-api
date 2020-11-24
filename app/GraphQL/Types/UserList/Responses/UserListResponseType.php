<?php

namespace App\GraphQL\Types\UserList\Responses;

use App\GraphQL\Types\Core\JsonResponse\JsonResponseType;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;

class UserListResponseType extends JsonResponseType
{
    protected $attributes = [
        'name' => 'UserListResponse',
        'description' => 'User List Response',
    ];

    public function fields(): array
    {
        $fields = parent::fields();

        return array_merge($fields, [
            'data' => [
                'type' => Type::listOf(GraphQL::type('User')),
                'description' => 'User List',
            ]
        ]);
    }
}
