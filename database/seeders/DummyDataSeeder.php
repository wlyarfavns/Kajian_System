<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Mosque;
use App\Models\Speaker;
use App\Models\Organizer;
use App\Models\Kajian;
use App\Models\Favorite;
use App\Models\KajianAttendee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@kajianku.test'],
            ['name' => 'Administrator', 'password' => Hash::make('password'), 'role' => 'admin']
        );

        // 2. Create Jamaah User
        $jamaah = User::firstOrCreate(
            ['email' => 'jamaah@kajianku.test'],
            ['name' => 'Fulan bin Fulan', 'password' => Hash::make('password'), 'role' => 'user']
        );

        // 3. Create Organizer User
        $orgUser = User::firstOrCreate(
            ['email' => 'organizer@kajianku.test'],
            ['name' => 'Takmir Masjid', 'password' => Hash::make('password'), 'role' => 'organizer']
        );
        $organizer = Organizer::firstOrCreate(
            ['user_id' => $orgUser->id],
            ['name' => 'Takmir Masjid', 'is_verified' => true]
        );

        // 3. Create Categories
        $cats = ['Aqidah', 'Fiqih', 'Keluarga', 'Bisnis', 'Tahsin'];
        $categories = [];
        foreach ($cats as $c) {
            $categories[] = Category::firstOrCreate(['name' => $c], ['slug' => strtolower($c)]);
        }

        // 4. Create Speakers
        $spks = ['Ustadz Dr. Syafiq Riza Basalamah', 'Ustadz Firanda Andirja', 'Ustadz Khalid Basalamah'];
        $speakers = [];
        foreach ($spks as $s) {
            $speakers[] = Speaker::firstOrCreate(['name' => $s]);
        }

        // 5. Create Mosques
        $msqs = [
            ['name' => 'Masjid Istiqlal', 'address' => 'Jl. Taman Wijaya Kusuma, Jakarta Pusat', 'lat' => -6.170170, 'lng' => 106.831390],
            ['name' => 'Masjid Al-Azhar', 'address' => 'Jl. Sisingamangaraja, Kebayoran Baru', 'lat' => -6.234676, 'lng' => 106.799793],
            ['name' => 'Masjid Salman ITB', 'address' => 'Jl. Ganesa No.7, Bandung', 'lat' => -6.892408, 'lng' => 107.610542]
        ];
        $mosques = [];
        foreach ($msqs as $m) {
            $mosques[] = Mosque::firstOrCreate(['name' => $m['name']], [
                'organizer_id' => $organizer->id,
                'address' => $m['address'],
                'latitude' => $m['lat'],
                'longitude' => $m['lng']
            ]);
        }

        // 6. Create 10+ Kajians
        $kajiansData = [];
        for ($i = 1; $i <= 12; $i++) {
            $date = Carbon::now()->addDays(rand(-2, 10))->setTime(rand(8, 20), 0);
            $cat = $categories[array_rand($categories)];
            $mosque = $mosques[array_rand($mosques)];
            
            $kajiansData[] = Kajian::create([
                'title' => 'Kajian Spesial ' . $cat->name . ' Seri ' . $i,
                'organizer_id' => $organizer->id,
                'mosque_id' => $mosque->id,
                'speaker_id' => $speakers[array_rand($speakers)]->id,
                'category_id' => $cat->id,
                'description' => "Ini adalah deskripsi kajian tentang " . $cat->name . " yang akan dibahas mendalam. Fasilitas: Ruang ber-AC, Snack, Modul materi.",
                'start_at' => $date,
                'end_at' => (clone $date)->addHours(2),
                'address' => $mosque->address,
                'latitude' => $mosque->latitude + (rand(-100, 100) / 100000), // slight variation
                'longitude' => $mosque->longitude + (rand(-100, 100) / 100000),
                'audience' => rand(0, 1) ? 'umum' : 'ikhwan',
                'status' => 'published',
                'is_verified' => true,
                'is_free' => rand(0, 1) ? true : false,
                'price' => rand(0, 1) ? 0 : 50000,
                'is_family_friendly' => rand(0, 1) ? true : false,
            ]);
        }

        // 7. Seed Attendance and Favorites for Jamaah
        // Favorite the first 2 kajians
        Favorite::firstOrCreate(['user_id' => $jamaah->id, 'kajian_id' => $kajiansData[0]->id]);
        Favorite::firstOrCreate(['user_id' => $jamaah->id, 'kajian_id' => $kajiansData[1]->id]);

        // Attend the next 3
        KajianAttendee::firstOrCreate(['user_id' => $jamaah->id, 'kajian_id' => $kajiansData[2]->id], ['status' => 'registered']);
        KajianAttendee::firstOrCreate(['user_id' => $jamaah->id, 'kajian_id' => $kajiansData[3]->id], ['status' => 'attended', 'checked_in_at' => now()]);
        KajianAttendee::firstOrCreate(['user_id' => $jamaah->id, 'kajian_id' => $kajiansData[4]->id], ['status' => 'cancelled']);
    }
}
