<?php 

namespace Deviam\Bancard\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\{Model, Builder};

class Card extends Model
{
    protected $table = 'bancard_user_cards';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'user_id', 
        'user_cell_phone', 
        'user_mail', 
        'alias_token', 
        'card_masked_number', 
        'expiration_date', 
        'card_brand', 
        'card_type', 
        'active'
    ];

    protected $casts = [
        'id' => 'string',
        'active' => 'boolean',
    ];

    protected static function booted()
    {
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('active', true);
        });

        static::creating(function ($card) {
            $card->id = Str::uuid();
        });
    }
}