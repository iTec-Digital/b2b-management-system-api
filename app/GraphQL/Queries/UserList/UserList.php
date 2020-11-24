<?php

namespace App\GraphQL\Queries\UserList;

use App\Core\Features\UAP\UAP;
use App\Models\User\User;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\Type;

class UserList extends Query
{
    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    private $auth_user;
    /**
     * @var mixed|null
     */
    private $module_permissions;

    public function __construct()
    {
        $this->auth_user = auth()->user();
        $UAP = new UAP();
        $this->module_permissions = $UAP->FetchModulePermissions((int)$this->auth_user->id, 'USERS');
    }

    protected $attributes = [
        'name' => 'UserList',
        'description' => 'Get the user list',
    ];

    public function type(): Type
    {
        return GraphQL::type('UserListResponse');
    }

    public function args(): array
    {
        return [
            'ForDropdown' => ['name' => 'ForDropdown', 'type' => Type::boolean()],
        ];
    }

    public function resolve($root, $args)
    {
        $ForDropdown = isset($args['ForDropdown']) ? $args['ForDropdown'] : false;

        //Returns the default user list
        if(($this->module_permissions['MODULE_ACCESS'] && $this->module_permissions['VIEW']) || $ForDropdown) {
            return [
                'success' => true,
                'error_code' => null,
                'message' => 'User list got successfully!',
                'data' => User::orderBy('id', 'asc')->get(),
            ];
        }

        return [
            'success' => false,
            'error_code' => 'ACCESS_DENIED',
            'message' => 'You do not have permission for this action!',
        ];
    }
}
