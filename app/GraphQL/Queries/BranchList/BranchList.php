<?php

namespace App\GraphQL\Queries\BranchList;

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

    public function type(): Type
    {
        return GraphQL::type('BranchListResponse');
    }

    public function args(): array
    {
        return [
            'TrashMode' => ['name' => 'TrashMode', 'type' => Type::int()],
            'Active' => ['name' => 'Active', 'type' => Type::int()],
        ];
    }

    public function resolve($root, $args)
    {
        $auth_user = auth()->user();

        $sql = "SELECT * FROM user_branches INNER JOIN branch_list branch ON branch.id = user_branches.BranchID WHERE user_branches.UserID = '{$auth_user->id}'";

        if (isset($args['TrashMode'])) {
            $is_deleted = (int) $args['TrashMode'];
            $sql .= " AND branch.IsDeleted = '{$is_deleted}'";
        }

        if (isset($args['Active'])) {
            $is_active = (int) $args['Active'];
            $sql .= " AND branch.IsActive = '{$is_active}'";
        }

        try {
            $branch_list = DB::select($sql);

            return [
                'success' => true,
                'error_code' => null,
                'message' => 'Branch list got successfully!',
                'data' => $branch_list,
            ];
        }
        catch (Exception $e) {
            return [
                'success' => false,
                'error_code' => 'DB_ERROR',
                'message' => 'Failed to fetch the branch list! ' . $e->getMessage(),
            ];
        }
    }
}
