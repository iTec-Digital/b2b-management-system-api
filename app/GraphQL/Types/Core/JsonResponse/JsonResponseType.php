<?php


namespace App\GraphQL\Types\Core\JsonResponse;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class JsonResponseType extends GraphQLType
{
    protected $attributes = [
        'name' => 'JsonResponse',
        'description' => 'Json Response for API!'
    ];

    public function fields() : array {
        return [
            'success' => [
                'type' => Type::nonNull(Type::boolean()),
                'description' => 'Bool result of the response, whether success or not',
            ],
            'error_code' => [
                'type' => Type::string(),
                'description' => 'Error code from the response',
            ],
            'message' => [
                'type' => Type::string(),
                'description' => 'Response message',
            ],
        ];
    }
}
