<?php
namespace Database\Seeders;
use App\Models\Speaker;
use Illuminate\Database\Seeder;
class SpeakerSeeder extends Seeder
{
    public function run(): void
    {
        $speakers = [
            ['name' => 'Ustadz Abdullah Roy, M.A.', 'description' => 'Pengasuh Halaqah Silsilah Ilmiyyah (HSI)'],
            ['name' => 'Ustadz Dr. Syafiq Riza Basalamah, M.A.', 'description' => 'Alumni Universitas Islam Madinah'],
            ['name' => 'Ustadz Dr. Firanda Andirja, M.A.', 'description' => 'Penceramah tetap di Masjid Nabawi'],
        ];
        foreach ($speakers as $speaker) {
            Speaker::firstOrCreate(['name' => $speaker['name']], $speaker);
        }
    }
}
