<?php 

namespace Deviam\Bancard\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Confirmation extends Model
{
    protected $table = 'bancard_confirmations';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'shop_process_id', 
        'response', 
        'response_details', 
        'authorization_number', 
        'ticket_number', 
        'response_code', 
        'response_description', 
        'extended_response_description', 
        'card_source', 
        'customer_ip', 
        'card_country', 
        'version', 
        'risk_index'
    ];

    protected $casts = [
        'id' => 'string',
    ];

    public function getSourceAttribute()
    {
        return $this->card_source === 'L' ? 'Local' : 'Internacional';
    }

    public function getRiskAttribute()
    {
        $options = [
            'No se puede generar el riesgo en tiempo real', 
            'Bajo', 
            'Bajo', 
            'Bajo', 
            'Medio', 
            'Medio', 
            'Medio', 
            'Alto', 
            'Alto', 
            'Alto'
        ];

        return $options[$this->risk_index] ?? $options[0];
    }

    protected static function booted()
    {
        static::creating(function ($confirmation) {
            $confirmation->id = Str::uuid();
        });
    }
}