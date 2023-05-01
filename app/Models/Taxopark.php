<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperTaxopark
 */
class Taxopark extends Model
{
    public $table = 'taxoparks';

    public static function default(): Taxopark
    {
        $taxopark = new Taxopark();
        $taxopark->name = 'default';
        $taxopark->park_id = env('PARK_ID');
        $taxopark->client_id = env('CLIENT_ID');
        $taxopark->api_key = env('API_KEY');

        return $taxopark;
    }

    public function tgUsers(): HasMany
    {
        return $this->hasMany(TgUser::class);
    }
}
