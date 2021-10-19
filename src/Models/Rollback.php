<?php 

namespace Deviam\Bancard\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Rollback extends Model
{
    protected $table = 'bancard_rollbacks';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'shop_process_id', 
        'status', 
        'key', 
        'level', 
        'dsc'
    ];

    protected $casts = [
        'id' => 'string',
    ];

    protected static function booted()
    {
        static::creating(function ($rollback) {
            $rollback->id = Str::uuid();
        });
    }
}