<?php


namespace App\Core\Classes\BRANCH;


use App\Models\User\User;
use App\Models\UserBranch\UserBranch;

class BRANCH
{
    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    private $auth_user;

    public function __construct()
    {
        $this->auth_user = auth()->user();
    }

    /**
     * Validate the branch id, if this branch id belongs to the user then returns true else false,
     * also checks the invalid value
     * @param int $branchId
     * @return bool
     */
    public static function VALIDATE_ID(int $branchId)
    {
        $auth_user = auth()->user();
        $user_branch = UserBranch::where('userID', '=', $auth_user->id)->where('BranchID', '=', $branchId);

        if ($user_branch->exists()) {
            return true;
        }

        return false;
    }

    /**
     * Switch the current branch id
     * @param int $branchId
     * @return bool
     */
    public static function SWITCH_ID(int $branchId)
    {
        $auth_user = auth()->user();

        $update = User::where('id', '=', $auth_user->id)->update([
            'LoggedInBranchID' => $branchId,
        ]);

        return $update;
    }
}
