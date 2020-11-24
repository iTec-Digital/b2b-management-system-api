<?php


namespace App\GraphQL\Types\UAP\Responses;


use App\GraphQL\Types\Core\JsonResponse\JsonResponseType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class UAPResponseType extends JsonResponseType
{
    protected $attributes = [
        'name' => 'UAPResponse',
        'description' => 'User Access Permission data response',
    ];

    public function fields(): array
    {
        $fields = parent::fields();

        return array_merge($fields, [
            'data' => [
                'type' => GraphQL::type('AppModule'),
                'description' => 'Application Module List with their permissions',
            ],
        ]);
    }
}
