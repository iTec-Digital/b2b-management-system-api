<?php

namespace App\Models\Branch;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $table = 'branch_list';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
}
