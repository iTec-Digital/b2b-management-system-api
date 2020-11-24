<?php


namespace App\GraphQL\Types\UAP;

use App\Core\Features\UAP\UAP;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ModulePermissionType extends GraphQLType
{
    protected $attributes = [
        'name' => 'ModulePermission',
        'description' => 'Application module permission',
    ];

    public function fields(): array
    {
        $UAP = new UAP();
        $fields = [];
        foreach ($UAP->ActionButtons as $actionButton) {
            $fields[$actionButton['Code']] = [
                'type' => Type::boolean(),
                'description' => $actionButton['Description'],
            ];
        }

        return $fields;
    }
}
