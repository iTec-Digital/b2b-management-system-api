<?php


namespace App\GraphQL\Queries\Core\Connectivity;


use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class Connectivity extends Query
{
    protected $attributes = [
        'name' => 'FRONT_END_CONNECTIVITY',
        'description' => 'Front-End connection status',
    ];

    public function type() : Type {
        return GraphQL::type('JsonResponse');
    }

    public function args() : array {
        return [

        ];
    }

    public function resolve($root, $args) {
        return [
            'success' => true,
            'error_code' => null,
            'message' => 'You are connected!',
        ];
    }
}
