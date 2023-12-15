<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'name',
        'mother_name',
        'document',
        'cns',
        'picture_url',
    ];

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class, 'id', 'address_id');
    }
}
