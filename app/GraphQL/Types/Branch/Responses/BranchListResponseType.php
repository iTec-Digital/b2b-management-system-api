<?php

namespace App\GraphQL\Types\Branch\Responses;

use App\GraphQL\Types\Core\JsonResponse\JsonResponseType;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;

class BranchListResponseType extends JsonResponseType
{
    protected $attributes = [
        'name' => 'BranchListResponse',
        'description' => 'Branch List Response',
    ];

    public function fields(): array
    {
        $fields = parent::fields();

        return array_merge($fields, [
            'data' => [
                'type' => Type::listOf(GraphQL::type('Branch')),
                'description' => 'Branch List',
            ]
        ]);
    }
}
