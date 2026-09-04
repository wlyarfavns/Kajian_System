<?php
$attendees = \App\Models\KajianAttendee::all();
foreach($attendees as $a) {
    // distribute dates between 0 to 90 days ago
    $a->created_at = now()->subDays(rand(0, 90))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
    $a->save(['timestamps' => false]);
}
echo "Done scattering dates.\n";
