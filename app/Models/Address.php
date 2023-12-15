<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'addresses';

    protected $fillable = [
        'address',
        'number',
        'complement',
        'neighborhood'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'address_id');
    }
}
