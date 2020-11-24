<?php

namespace App\GraphQL\Types\Login\Responses;

use App\GraphQL\Types\Core\JsonResponse\JsonResponseType;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;

class LoginResponseType extends JsonResponseType
{
    protected $attributes = [
        'name' => 'LoginResponse',
        'description' => 'Login Response',
    ];

    public function fields(): array
    {
        $fields = parent::fields();

        return array_merge($fields, [
            'token' => [
                'type' => Type::string(),
                'description' => 'Auth token',
            ],
        ]);
    }
}
