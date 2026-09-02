<?php
namespace Database\Seeders;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Tahsin', 'Fiqih', 'Aqidah', 'Parenting', 'Bisnis', 'Muslimah', 'Keluarga', 'Kajian Umum'
        ];
        foreach ($categories as $category) {
            Category::firstOrCreate([
                'slug' => Str::slug($category)
            ], [
                'name' => $category,
            ]);
        }
    }
}
