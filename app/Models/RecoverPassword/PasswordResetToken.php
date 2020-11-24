<?php

namespace App\Models\RecoverPassword;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    use HasFactory;
    protected $table = "user_password_reset_tokens";
    protected $primaryKey = "id";
    protected $fillable = ['EmailAddress', 'Token', 'CreatedAt'];
    public $incrementing = false;
    public $timestamps = false;
}
