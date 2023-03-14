<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @mixin IdeHelperTgUser
 */
class TgUser extends Model
{
    use SoftDeletes;

    public $table = 'tg_users';

    public static function generateReferralHash(): string
    {
        do {
            $code = Str::random(8);

            $tgUser = self::whereReferralHash($code)
                ->first();
        } while (!empty($tgUser));

        return $code;
    }
}
