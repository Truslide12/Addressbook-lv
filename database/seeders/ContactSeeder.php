<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ContactTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\Contact::factory()->create(100)
            ->each(function($contact) {
                $contact->addresses()->save(
                    App\Models\Address::factory()->make()
                );
        });
    }
}
