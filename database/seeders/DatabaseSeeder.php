<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Subjects;
use App\Models\Theme;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'New',
            'surname' => 'Admin',
            'email' => 'newadmin@new.admin',
            'password' => Hash::make('password'),
            'usertype' => 'admin',
        ]);

        User::create([
            'name' => 'New',
            'surname' => 'User',
            'email' => 'newuser@new.user',
            'password' => Hash::make('password'),
            'usertype' => 'user',
        ]);


        Subjects::create([
            'name' => 'Matemātika II',
            'form' => 'Vidusskola',
        ]);

        Theme::create([
            'text' => 'Algebra',
            'macibu_prieksmets_id' => '1',
        ]);
        Theme::create([
            'text' => 'Geometrija',
            'macibu_prieksmets_id' => '1',
        ]);

        Subjects::create([
            'name' => 'Fizika',
            'form' => '9. klase',
        ]);

        Theme::create([
            'text' => 'Atomi',
            'macibu_prieksmets_id' => '2',
        ]);
        Theme::create([
            'text' => 'Astronomija',
            'macibu_prieksmets_id' => '2',
        ]);

    }
}
