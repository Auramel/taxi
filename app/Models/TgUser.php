<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function referrals(): HasMany
    {
        return $this->hasMany(Referral::class, 'from_tg_user_id', 'id');
    }

    public function taxopark(): BelongsTo
    {
        return $this->belongsTo(Taxopark::class);
    }
}
