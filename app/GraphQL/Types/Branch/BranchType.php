<?php

namespace App\GraphQL\Types\Branch;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class BranchType extends GraphQLType {
    protected $attributes = [
        'name' => 'Branch',
        'description' => 'Detail of a branch',
    ];

    public function fields() : array {
        return [
            'id' => [
                'type' => Type::int(),
                'description' => 'Id of the branch',
            ],
            'IsActive' => [
                'type' => Type::int(),
                'description' => 'Active status of the branch',
            ],
            'IsDeleted' => [
                'type' => Type::int(),
                'description' => 'Deleted status of the branch',
            ],
            'Name' => [
                'type' => Type::string(),
                'description' => 'Name of the branch',
            ],
            'Email' => [
                'type' => Type::string(),
                'description' => 'Email address of the branch',
            ],
            'ContactNumber' => [
                'type' => Type::string(),
                'description' => 'Contact Number of the branch',
            ],
            'Address' => [
                'type' => Type::string(),
                'description' => 'Address of the branch',
            ],
            'CreatedBy' => [
                'type' => Type::int(),
                'description' => 'User id of the creator of the branch',
            ],
            'CreatedAt' => [
                'type' => Type::string(),
                'description' => 'Date time of the entry of the branch',
            ],
            'UpdatedBy' => [
                'type' => Type::int(),
                'description' => 'User id of who updated the branch',
            ],
            'UpdatedAt' => [
                'type' => Type::string(),
                'description' => 'Date time of the updated meantime of the branch',
            ],
            'DeletedBy' => [
                'type' => Type::int(),
                'description' => 'User id of who deleted the branch',
            ],
            'DeletedAt' => [
                'type' => Type::string(),
                'description' => 'Date time of the delete of the branch',
            ],
        ];
    }
}
