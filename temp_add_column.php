<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

if (!Illuminate\Support\Facades\Schema::hasColumn('kajians', 'google_maps_url')) {
    Illuminate\Support\Facades\Schema::table('kajians', function(\Illuminate\Database\Schema\Blueprint $table) {
        $table->string('google_maps_url')->nullable()->after('longitude');
    });
    echo 'Column added.';
} else {
    echo 'Column already exists.';
}
