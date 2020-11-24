<?php

namespace App\Models\UserPermissions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermissions extends Model
{
    use HasFactory;
    protected $table = 'user_permissions';
    public $timestamps = false;
}
