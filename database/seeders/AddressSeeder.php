<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Address;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Address::factory()->create([ 
            'postal_code' => '86705200',
            'address' => 'Rua Seringueiro',
            'number' => '120',
            'complement' => '',
            'neighborhood' => 'Vila Edio',
            'city' => 'Arapongas',
            'state' => 'PR'
        ]);

        Address::factory()->create([ 
            'postal_code' => '69044793',
            'address' => 'Travessa Pedro Caetano',
            'number' => '655',
            'complement' => 'Casa B',
            'neighborhood' => 'Planalto',
            'city' => 'Manaus',
            'state' => 'AM'
        ]);

        Address::factory()->create([ 
            'postal_code' => '74675390',
            'address' => 'Rua Ipameri',
            'number' => '280',
            'complement' => 'Bloco 10 apto 401',
            'neighborhood' => 'Jardim Guanabara',
            'city' => 'Goiânia',
            'state' => 'GO'
        ]);
    }
}
