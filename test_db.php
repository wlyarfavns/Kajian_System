<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$result = \DB::table('kajians')->latest('id')->take(3)->get(['title', 'start_at', 'end_at']);
echo json_encode($result, JSON_PRETTY_PRINT);
