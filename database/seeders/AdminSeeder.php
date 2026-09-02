<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate([
            'email' => 'admin@kajiansystem.test'
        ], [
            'name' => 'Admin Kajian System',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }
}
