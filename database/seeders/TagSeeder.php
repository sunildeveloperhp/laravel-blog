<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Beginner', 'Tutorial', 'Tips', 'Eloquent', 'Blade',
            'Security', 'Performance', 'Tailwind', 'Best Practices', 'Career Advice',
        ];

        foreach ($names as $name) {
            Tag::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }
    }
}
