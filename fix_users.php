<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    \DB::statement("ALTER TABLE users ADD COLUMN google_id VARCHAR(255) NULL AFTER email");
    echo "Added google_id column.\n";
} catch (\Exception $e) {
    echo "google_id column might already exist.\n";
}

try {
    \DB::statement("ALTER TABLE users MODIFY COLUMN password VARCHAR(255) NULL");
    echo "Made password nullable.\n";
} catch (\Exception $e) {
    echo "Failed to make password nullable.\n";
}
