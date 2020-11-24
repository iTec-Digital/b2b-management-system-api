<?php

namespace App\GraphQL\Mutations\SwitchBranch;

use App\Core\Classes\BRANCH\BRANCH;
use App\Models\User\User;
use Exception;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class SwitchBranch extends Mutation
{
    protected $attributes = [
        'name' => 'SwitchBranch',
        'description' => 'Switch the current logged in branch id',
    ];

    public function type(): Type
    {
        return GraphQL::type('JsonResponse');
    }

    public function args(): array
    {
        return [
            'BranchId' => [
                'type' => Type::int(),
                'description' => 'Id of the branch',
                'rules' => ['required'],
            ],
        ];
    }

    public function resolve($root, $args)
    {
        if (isset($args['BranchId']) && trim($args['BranchId']) != '') {
            $branchId = (int)$args['BranchId'];

            if (BRANCH::VALIDATE_ID($branchId)) {
                try {
                    BRANCH::SWITCH_ID($branchId);

                    return [
                        'success' => true,
                        'error_code' => null,
                        'message' => 'Branch Switched Successfully!',
                    ];
                } catch (Exception $e) {
                    return [
                        'success' => false,
                        'error_code' => 'DB_ERROR',
                        'message' => 'Failed to switch the branch! ' . $e->getMessage(),
                    ];
                }
            }
        }

        return [
            'success' => false,
            'error_code' => 'INVALID_BRANCH_ID',
            'message' => 'Please provide a valid branch id!',
        ];
    }
}
