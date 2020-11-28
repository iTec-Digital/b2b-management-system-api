<?php
$ActionButtons = require __DIR__ . '/ActionButtons.php';
$MODULE_ACCESS = $ActionButtons['MODULE_ACCESS'];
$ADD = $ActionButtons['ADD'];
$EDIT = $ActionButtons['EDIT'];
$VIEW = $ActionButtons['VIEW'];
$DELETE = $ActionButtons['DELETE'];
$TRASH = $ActionButtons['TRASH'];
$RESTORE = $ActionButtons['RESTORE'];
$DELETE_FOREVER = $ActionButtons['DELETE_FOREVER'];


/**
 | ---------------------------------------------------------------------------
 | Here Code and Key names must be same and unique
 | ---------------------------------------------------------------------------
 */
return [
    "USER_ACCESS_PERMISSIONS" => [
        "Code" => "USER_ACCESS_PERMISSIONS",
        "Label" => "User Access Permissions",
        "Description" => "Manage access permissions of all users",
        "ActionButtons" => [$MODULE_ACCESS, $EDIT]
    ],
    "USERS" => [
        "Code" => "USERS",
        "Label" => "User List",
        "Description" => "Manage all the users of the application",
        "ActionButtons" => [$MODULE_ACCESS, $ADD, $EDIT, $VIEW, $DELETE, $TRASH, $RESTORE, $DELETE_FOREVER]
    ],
    "SETTINGS" => [
        "Code" => "SETTINGS",
        "Label" => "Settings",
        "Description" => "Manage the application settings",
        "ActionButtons" => [$MODULE_ACCESS, $EDIT]
    ],
    "BRANCHES" => [
        "Code" => "BRANCHES",
        "Label" => "Branch List",
        "Description" => "Manage all the branches of the company",
        "ActionButtons" => [$MODULE_ACCESS, $ADD, $EDIT, $VIEW, $DELETE, $TRASH, $RESTORE, $DELETE_FOREVER]
    ],
];
