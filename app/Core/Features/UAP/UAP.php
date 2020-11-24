<?php


namespace App\Core\Features\UAP;


use App\Models\UserPermissions\UserPermissions;
use Exception;

class UAP
{
    public $ActionButtons, $AppModules;

    public function __construct()
    {
        $this->ActionButtons = require __DIR__ . '/ActionButtons.php';
        $this->AppModules = require __DIR__ . '/AppModules.php';
    }

    /**
     * Get permission of a single action by a module code and user id
     * @param int $user_id
     * @param string $module_code
     * @param string $action_code
     * @return bool
     */
    public function FetchModuleActionAccessPermission(int $user_id, string $module_code, string $action_code)
    {
        $UP = UserPermissions::where('UserID', '=', $user_id)->where('ModuleCode', '=', $module_code)->where('ActionCode', '=', $action_code);
        if ($UP->exists()) {
            return (int)$UP->first()->Permission === 1;
        }

        return false;
    }

    /**
     * Get all the permissions of a single module
     * @param int $user_id
     * @param string $module_code
     * @return array
     */
    public function FetchModulePermissions(int $user_id, string $module_code)
    {
        $Module = $this->AppModules[$module_code];
        $UP = [];

        foreach ($Module['ActionButtons'] as $actionButton) {
            $UP[$actionButton['Code']] = $this->FetchModuleActionAccessPermission($user_id, $module_code, $actionButton['Code']);
        }

        return $UP;
    }

    /**
     * Set permission for a single action button of a single module
     * @param int $user_id
     * @param string $module_code
     * @param string $action_code
     * @param bool $permission
     * @return bool
     */
    public function SetModuleActionAccessPermission(int $user_id, string $module_code, string $action_code, bool $permission)
    {
        $UP = UserPermissions::where('UserID', '=', $user_id)->where('ModuleCode', '=', $module_code)->where('ActionCode', '=', $action_code);
        if ($UP->exists()) {
            try {
                //Update the existing permission entry
                $UP->update([
                    'Permission' => $permission,
                ]);
            } catch (Exception $e) {
                return false;
            }
        } else {
            try {
                //Insert a new permission entry
                UserPermissions::Insert([
                    'UserID' => $user_id,
                    'ModuleCode' => $module_code,
                    'ActionCode' => $action_code,
                    'Permission' => $permission,
                ]);
            } catch (Exception $e) {
                return false;
            }
        }

        return true;
    }
}
