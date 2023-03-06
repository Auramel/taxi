<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperTgUser
 */
class TgUser extends Model
{
    public $table = 'tg_users';
}
