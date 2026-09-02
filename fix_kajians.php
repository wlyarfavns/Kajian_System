<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    \DB::statement("ALTER TABLE kajians ADD COLUMN facilities TEXT NULL");
    echo "Added facilities column to kajians.\n";
} catch (\Exception $e) {
    echo "facilities column might already exist. Error: " . $e->getMessage() . "\n";
}
