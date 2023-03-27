<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperReferral
 */
class Referral extends Model
{
    use SoftDeletes;

    public $table = 'referrals';

    public function from(): HasOne
    {
        return $this->hasOne(TgUser::class, 'id', 'from_tg_user_id');
    }

    public function income(): HasOne
    {
        return $this->hasOne(TgUser::class, 'id', 'income_tg_user_id');
    }
}
