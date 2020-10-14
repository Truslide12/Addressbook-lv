<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Enumerable;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Faker\Generator as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contacts')->insert([
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'email' => $this->faker->unique()->email,
            'phone' => $this->faker->phoneNumber,
            'birthday' => $this->faker->date($format = 'Y-m-d', $max = 'now')
        ]);
    }
}
