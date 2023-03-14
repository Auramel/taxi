<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperReferral
 */
class Referral extends Model
{
    use SoftDeletes;

    public $table = 'referrals';
}
