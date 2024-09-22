<?php

namespace App\Models\Admin\Cars;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarPrice extends Model
{
    use HasFactory;
    protected $table = 'car_prices';

    protected $fillable = [
        'car_id', 'price', 'from', 'destination'
    ];

    public function carType()
    {
        return $this->belongsTo(CarType::class, 'car_id');
    }

    public function originArea()
    {
        return $this->belongsTo(CarArea::class, 'from');
    }

    public function destinationArea()
    {
        return $this->belongsTo(CarArea::class, 'destination');
    }
}
