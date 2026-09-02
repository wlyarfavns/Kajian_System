<?php
namespace Database\Seeders;
use App\Models\User;
use App\Models\Organizer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class OrganizerSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate([
            'email' => 'organizer@kajiansystem.test'
        ], [
            'name' => 'Ustadz Fauzan Organizer',
            'password' => Hash::make('password'),
            'role' => 'organizer',
        ]);
        Organizer::firstOrCreate([
            'user_id' => $user->id
        ], [
            'name' => 'Yayasan Al Ikhlas',
            'description' => 'Yayasan dakwah sunnah di Yogyakarta.',
            'address' => 'Jl. Kaliurang KM 5, Yogyakarta',
            'latitude' => -7.759495,
            'longitude' => 110.381335,
            'is_verified' => true,
        ]);
    }
}
