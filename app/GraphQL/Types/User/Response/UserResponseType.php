<?php

namespace GraphQL\Types\User\Response;

use App\GraphQL\Types\Core\JsonResponse\JsonResponseType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class UserResponseType extends JsonResponseType
{
    protected $attributes = [
        'name' => 'UserResponse',
        'description' => 'User Information Response',
    ];

    public function fields(): array
    {
        $fields = parent::fields();

        return array_merge($fields, [
            'data' => [
                'type' => GraphQL::type('User'),
                'description' => 'User Information',
            ]
        ]);
    }
}
