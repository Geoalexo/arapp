<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name'  => 'Test User',
            'email' => 'test@test.com',
        ]);

        $categories = [
            [
                'name'       => 'Museums',
                'is_visible' => true,
            ],
            [
                'name'       => 'Temples',
                'is_visible' => true,
            ],
            [
                'name'       => 'Statues',
                'is_visible' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::factory()->create($category);
        }
    }
}
