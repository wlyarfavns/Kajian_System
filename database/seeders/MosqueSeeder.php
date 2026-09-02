<?php
namespace Database\Seeders;
use App\Models\Mosque;
use App\Models\Organizer;
use Illuminate\Database\Seeder;
class MosqueSeeder extends Seeder
{
    public function run(): void
    {
        $organizer = Organizer::where('name', 'Yayasan Al Ikhlas')->first();
        if ($organizer) {
            $mosques = [
                [
                    'organizer_id' => $organizer->id,
                    'name' => 'Masjid Kampus UGM',
                    'address' => 'Bulaksumur, Caturtunggal, Depok, Sleman',
                    'latitude' => -7.773822,
                    'longitude' => 110.379469,
                ],
                [
                    'organizer_id' => $organizer->id,
                    'name' => 'Masjid Pogung Dalangan',
                    'address' => 'Pogung Dalangan, Sinduadi, Mlati, Sleman',
                    'latitude' => -7.759367,
                    'longitude' => 110.374665,
                ],
            ];
            foreach ($mosques as $mosque) {
                Mosque::firstOrCreate(['name' => $mosque['name']], $mosque);
            }
        }
    }
}
