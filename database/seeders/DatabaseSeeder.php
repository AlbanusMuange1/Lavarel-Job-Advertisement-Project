<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Listing;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
          'name' => 'Albanus',
          'email' => 'albanusmuangemutunga@gmail.com',
          'password' => 'admin12345'
        ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // Listing::factory(6)->create([
        //   'user_id' => $user->id
        // ]);
        Listing::create([
            'user_id' => $user->id,
            'title' => 'Laravel Senior Developer',
            'tags' => 'laravel, javascript',
            'company' => 'Alba Coding',
            'location' => 'Machakos, Kenya',
            'email' => 'alba@gmail.com',
            'website' => 'https://www.trending-news.com',
            'description' => 'The lastest update on the Maandamano going on in
            Kenya. Deaths are over 20 as we say and there will be more maandamano
            from netw week on Wednesday to Friday. This maadamano will completely kill the economy of Kenya.'
        ]);

        Listing::create([
            'user_id' => $user->id,
            'title' => 'Full Stack Developer',
            'tags' => 'laravel, backend, api',
            'company' => 'Missie Coding Corp',
            'location' => 'Nairobi, Kenya',
            'email' => 'missie@gmail.com',
            'website' => 'https://www.missie-coding-corp.com',
            'description' => 'The lastest update on the Maandamano going on in
            Kenya. Deaths are over 20 as we say and there will be more maandamano
            from netw week on Wednesday to Friday. This maadamano will completely kill the economy of Kenya.'
        ]);
    }
}
