<?php

namespace GraphQL\Types\User;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType {
    protected $attributes = [
        'name' => 'User',
        'description' => 'Detail of a user',
    ];

    public function fields() : array {
        return [
            'id' => [
                'type' => Type::id(),
                'description' => 'User ID',
            ],
            'Code' => [
                'type' => Type::string(),
                'description' => 'Code of the user',
            ],
            'LoggedInBranchID' => [
                'type' => Type::id(),
                'description' => 'Logged in branch id',
            ],
            'IsActive' => [
                'type' => Type::int(),
                'description' => 'Active status of the user',
            ],
            'IsDeleted' => [
                'type' => Type::int(),
                'description' => 'Deleted status of the user',
            ],
            'UserRoleID' => [
                'type' => Type::id(),
                'description' => 'User Role id',
            ],
            'FullName' => [
                'type' => Type::string(),
                'description' => 'Full name of the user',
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'Email address of the user',
            ],
            'ContactNumber' => [
                'type' => Type::string(),
                'description' => 'Contact Number of the user',
            ],
            'Address' => [
                'type' => Type::string(),
                'description' => 'Address of the user',
            ],
            'ProfilePhoto' => [
                'type' => Type::string(),
                'description' => 'Profile photo of the user of the user',
            ],
            'CreatedBy' => [
                'type' => Type::id(),
                'description' => 'User id of the user who created this user',
            ],
            'UpdatedBy' => [
                'type' => Type::id(),
                'description' => 'User id of the user who updated this user',
            ],
            'DeletedBy' => [
                'type' => Type::id(),
                'description' => 'User id of the user who deleted this user',
            ],
            'CreatedAt' => [
                'type' => Type::string(),
                'description' => 'Created Date time',
            ],
            'UpdatedAt' => [
                'type' => Type::string(),
                'description' => 'Updated Date time',
            ],
            'DeletedAt' => [
                'type' => Type::string(),
                'description' => 'Deleted Date time',
            ],


            'Description' => [
                'type' => Type::string(),
                'description' => 'Short description of the user',
            ],
        ];
    }
}
