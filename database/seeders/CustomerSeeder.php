<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;


class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::factory()->create([ 
            'address_id' => '1',
            'name' => 'Kauan Fernandes Martins',
            'mother_name' => 'Lavinia Barros Goncalves',
            'document' => '22339637090',
            'cns' => '316621380001805',
            'picture_url' => 'picture04.jpg',
        ]);

        Customer::factory()->create([ 
            'address_id' => '2',
            'name' => 'Felipe Martins Dias',
            'mother_name' => 'Luana Santos Azevedo',
            'document' => '77257645000',
            'cns' => '316621380001804',
            'picture_url' => 'picture03.jpg',
        ]);

        Customer::factory()->create([ 
            'address_id' => '2',
            'name' => 'Laura Almeida Castro',
            'mother_name' => 'Luana Santos Azevedo',
            'document' => '31348844027',
            'cns' => '316621380001803',
            'picture_url' => 'picture02.jpg',
        ]);

        Customer::factory()->create([ 
            'address_id' => '3',
            'name' => 'Ryan Melo Souza',
            'mother_name' => 'Vitoria Araujo Martins',
            'document' => '07841595050',
            'cns' => '316621380001801',
            'picture_url' => 'picture01.jpg',
        ]);
    }
}
