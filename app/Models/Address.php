<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    protected $table = 'addresses';

    protected $fillable = [
        'postal_code',
        'address',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'address_id', 'id');
    }
}
