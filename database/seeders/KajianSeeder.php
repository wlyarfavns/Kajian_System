<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class KajianSeeder extends Seeder
{
    public function run(): void
    {
        $organizer = \App\Models\Organizer::first();
        $mosque = \App\Models\Mosque::first();
        $speaker = \App\Models\Speaker::first();
        $category = \App\Models\Category::first();
        if (!$organizer || !$mosque || !$speaker || !$category) {
            return;
        }
        $kajians = [
            [
                'title' => 'Kajian Rutin Fiqih Muamalah',
                'organizer_id' => $organizer->id,
                'mosque_id' => $mosque->id,
                'speaker_id' => $speaker->id,
                'category_id' => $category->id,
                'description' => 'Membahas bab jual beli.',
                'start_at' => now()->addDays(2)->setTime(19, 30),
                'end_at' => now()->addDays(2)->setTime(21, 0),
                'address' => 'Jl. Kebahagiaan No. 1',
                'latitude' => -6.200000,
                'longitude' => 106.816666,
                'audience' => 'umum',
                'status' => 'published',
                'is_verified' => false,
            ],
            [
                'title' => 'Mendidik Anak Sesuai Sunnah',
                'organizer_id' => $organizer->id,
                'mosque_id' => $mosque->id,
                'speaker_id' => $speaker->id,
                'category_id' => $category->id,
                'description' => 'Kajian parenting.',
                'start_at' => now()->addDays(5)->setTime(9, 0),
                'end_at' => now()->addDays(5)->setTime(11, 30),
                'address' => 'Jl. Pendidikan No. 2',
                'latitude' => -6.210000,
                'longitude' => 106.826666,
                'audience' => 'umum',
                'status' => 'published',
                'is_verified' => false,
            ]
        ];
        foreach ($kajians as $kajian) {
            \App\Models\Kajian::create($kajian);
        }
    }
}
