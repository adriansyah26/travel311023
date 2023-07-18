<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Type;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'phone', 'email', 'address', 'type'
    ];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }
}
