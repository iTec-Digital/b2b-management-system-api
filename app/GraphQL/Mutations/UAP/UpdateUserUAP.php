<?php


namespace App\GraphQL\Mutations\UAP;


use App\Core\Features\UAP\UAP;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class UpdateUserUAP extends Mutation
{
    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    private $auth_user;
    /**
     * @var mixed|null
     */
    private $module_permissions;

    protected $attributes = [
        'name' => 'UpdateUserUAP',
        'description' => 'Update user access permission',
    ];

    public function __construct()
    {
        $this->auth_user = auth()->user();
        $UAP = new UAP();
        $this->module_permissions = $UAP->FetchModulePermissions((int)$this->auth_user->id, 'USER_ACCESS_PERMISSIONS');
    }

    public function type(): Type
    {
        return GraphQL::type('JsonResponse');
    }

    public function args(): array
    {
        return [
            'UserId' => ['type' => Type::id(), 'description' => 'User Id', 'rules' => 'required'],
            'ModuleCode' => ['type' => Type::string(), 'description' => 'Module Code', 'rules' => 'required'],
            'ActionCode' => ['type' => Type::string(), 'description' => 'Action Code', 'rules' => 'required'],
            'Permission' => ['type' => Type::boolean(), 'description' => 'Permission Value', 'rules' => 'required'],
        ];
    }

    public function resolve($root, $args) {
        $auth_user = auth()->user();
        $user_id = (int) 0;
        $module_code = (string) '';
        $action_code = (string) '';
        $permission = (bool) false;

        if(isset($args['UserId'])) {
            $user_id = (int) $args['UserId'];
        }

        if(isset($args['ModuleCode'])) {
            $module_code = (string) $args['ModuleCode'];
        }

        if(isset($args['ActionCode'])) {
            $action_code = (string) $args['ActionCode'];
        }

        if(isset($args['Permission'])) {
            $permission = (bool) $args['Permission'];
        }

        if($user_id !== 0 && $module_code !== '' && $action_code !== '' && $permission !== '') {

            $UAP = new UAP();

            if($this->module_permissions['MODULE_ACCESS'] && $this->module_permissions['EDIT']) {
                if($UAP->SetModuleActionAccessPermission($user_id, $module_code, $action_code, $permission)) {
                    return [
                        'success' => true,
                        'error_code' => null,
                        'message' => 'Permission set successfully!',
                    ];
                } else {
                    return [
                        'success' => false,
                        'error_code' => null,
                        'message' => 'Error occurred while setting the permission!',
                    ];
                }
            }

            return [
                'success' => false,
                'error_code' => 'ACCESS_DENIED',
                'message' => 'You do not have permission for this action',
            ];
        }

        //validation error occurred
        return [
            'success' => false,
            'message' => 'Please select a user and choose some permissions!',
        ];
    }
}
