<?php


namespace App\GraphQL\Types\UAP;

use App\Core\Features\UAP\UAP;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class AppModuleType extends GraphQLType
{
    protected $attributes = [
        'name' => 'AppModule',
        'description' => 'Application module',
    ];

    public function fields() : array {
        $UAP = new UAP();
        $fields = [];
        foreach ($UAP->AppModules as $appModule) {
            $fields[$appModule['Code']] = [
                'type' => GraphQL::type('ModulePermission'),
                'description' => $appModule['Description']
            ];
        }

        return $fields;
    }
}
