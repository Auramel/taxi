<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperCar
 */
class Car extends Model
{
    use SoftDeletes;

    public $table = 'cars';

    public function tgUser(): BelongsTo
    {
        return $this->belongsTo(TgUser::class);
    }
}
