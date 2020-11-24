<?php


namespace App\GraphQL\Queries\UAP;


use App\Core\Features\UAP\UAP;
use Exception;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class GetModules extends Query
{
    protected $attributes = [
        'name' => 'GetModules',
        'description' => 'Get the application module list with their permission details!',
    ];

    public function type(): Type
    {
        return GraphQL::type('UAPResponse');
    }

    public function args(): array
    {
        return [
            'UserId' => ['type' => Type::id(), 'description' => 'User Id'],
        ];
    }

    public function resolve($root, $args)
    {
        $user_id = auth()->user()->id;
        if (isset($args['UserId']) && $args['UserId'] !== '') {
            $user_id = $args['UserId'];
        }

        try {
            $UAP = new UAP();
            $Modules = [];

            foreach ($UAP->AppModules as $appModule) {
                $Modules[$appModule['Code']] = $UAP->FetchModulePermissions($user_id, $appModule['Code']);
            }

            return [
                'success' => true,
                'error_code' => null,
                'message' => 'Module List fetched successfully!',
                'data' => $Modules,
            ];
        } catch (Exception $exception) {
            return [
                'success' => false,
                'error_code' => 'DB_ERROR',
                'message' => 'Something went wrong! ' . $exception->getMessage(),
            ];
        }

    }
}
