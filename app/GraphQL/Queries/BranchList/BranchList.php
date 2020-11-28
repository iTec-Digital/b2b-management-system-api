<?php

namespace App\GraphQL\Queries\BranchList;

use App\Core\Features\UAP\UAP;
use Exception;
use Illuminate\Support\Facades\DB;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;

class BranchList extends Query
{
    protected $attributes = [
        'name' => 'BranchList',
        'description' => 'List of the Branches',
    ];
    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    private $auth_user;
    /**
     * @var array
     */
    private $module_permissions;

    public function __construct()
    {
        $this->auth_user = auth()->user();
        $UAP = new UAP();
        $this->module_permissions = $UAP->FetchModulePermissions((int)$this->auth_user->id, 'USER_ACCESS_PERMISSIONS');
    }

    public function type(): Type
    {
        return GraphQL::type('BranchListResponse');
    }

    public function args(): array
    {
        return [
            'SelfMode' => ['name' => 'SelfMode', 'type' => Type::boolean()],
            'TrashMode' => ['name' => 'TrashMode', 'type' => Type::int()],
            'Active' => ['name' => 'Active', 'type' => Type::int()],
            'SearchQuery' => ['name' => 'SearchQuery', 'type' => Type::string()],
            'PageNumber' => ['name' => 'PageNumber', 'type' => Type::int()],
            'Limit' => ['name' => 'Limit', 'type' => Type::int()],
        ];
    }

    public function resolve($root, $args)
    {
        $auth_user = auth()->user();
        $SelfMode = isset($args['SelfMode']) ? (bool)$args['SelfMode'] : false;

        if ($SelfMode) {
            $sql = "SELECT branch.id, branch.IsActive, branch.IsDeleted, branch.Name, branch.Address, branch.ContactNumber, branch.Email, branch.CreatedAt, branch.CreatedBy, branch.UpdatedAt, branch.UpdatedBy, branch.DeletedAt, branch.DeletedBy FROM user_branches INNER JOIN branch_list branch ON branch.id = user_branches.BranchID WHERE user_branches.UserID = '{$auth_user->id}'";
        } else {
            if (!($this->module_permissions['MODULE_ACCESS'])) {
                return [
                    'success' => false,
                    'error_code' => 'ACCESS_DENIED',
                    'message' => 'You do not have permission for this action!',
                ];
            }

            $sql = "SELECT * FROM branch_list branch WHERE id <> 0";
        }

        if (isset($args['TrashMode'])) {
            $is_deleted = (int)$args['TrashMode'];
            $sql .= " AND branch.IsDeleted = '{$is_deleted}'";
        }

        if (isset($args['Active'])) {
            $is_active = (int)$args['Active'];
            $sql .= " AND branch.IsActive = '{$is_active}'";
        }

        if (isset($args['SearchQuery'])) {
            $search_query = (string)$args['SearchQuery'];
            $search_query = urldecode($search_query);
            $search_query = addslashes($search_query);
            $sql .= " AND (branch.Name LIKE '%$search_query%')";
        }


        $page_number = 0;
        if (isset($args['PageNumber'])) {
            $page_number = $args['PageNumber'];
        }
        $page_number = (int)$page_number < 1 ? 1 : $page_number;

        $Limit = 0;
        if (isset($args['Limit'])) {
            $Limit = (int)$args['Limit'];
        }

        try {

            $TotalRows = DB::select("SELECT COUNT(*) as TotalRows FROM (" . $sql . ") as `ubb*`")[0]->TotalRows;
            $TotalPages = 1;

            if(!$SelfMode) {
                $TotalPages = ceil((int)$TotalRows / $Limit);
                $Offset = (((int)$page_number - 1) * $Limit);

                $sql .= " LIMIT " . $Offset . ", " . $Limit;
            }


            $branch_list = DB::select($sql);

            return [
                'success' => true,
                'error_code' => null,
                'message' => 'Branch list got successfully!' . $sql,
                'data' => $branch_list,
                'total_rows' => $TotalRows,
                'total_pages' => $TotalPages,
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error_code' => 'DB_ERROR',
                'message' => 'Failed to fetch the branch list! ' . $e->getMessage() . ' ' . $sql,
            ];
        }


    }
}
