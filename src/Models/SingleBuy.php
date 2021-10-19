<?php 

namespace Deviam\Bancard\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class SingleBuy extends Model
{
    protected $table = 'bancard_single_buys';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'shop_process_id', 
        'amount', 
        'currency', 
        'additional_data', 
        'description', 
        'status', 
        'process_id', 
        'zimple'
    ];

    protected $casts = [
        'id' => 'string',
        'zimple' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($singleBuy) {
            $singleBuy->id = Str::uuid();
        });
    }
}