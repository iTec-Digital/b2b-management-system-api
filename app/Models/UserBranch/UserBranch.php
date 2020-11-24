<?php

namespace App\Models\UserBranch;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBranch extends Model
{
    use HasFactory;
    protected $table = 'user_branches';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
}
