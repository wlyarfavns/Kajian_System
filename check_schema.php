<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$models = [
    \App\Models\User::class,
    \App\Models\Organizer::class,
    \App\Models\Mosque::class,
    \App\Models\Speaker::class,
    \App\Models\Category::class,
    \App\Models\Kajian::class,
    \App\Models\KajianAttendee::class,
    \App\Models\Favorite::class,
];

$allGood = true;

foreach ($models as $modelClass) {
    if (!class_exists($modelClass)) {
        echo "⚠️ Model $modelClass does not exist.\n";
        continue;
    }

    $model = new $modelClass();
    $table = $model->getTable();
    $fillable = $model->getFillable();

    if (empty($fillable)) {
        echo "⚠️ Model $modelClass has no \$fillable attributes defined.\n";
        continue;
    }

    $columns = \Schema::getColumnListing($table);
    
    $missingColumns = array_diff($fillable, $columns);
    
    if (!empty($missingColumns)) {
        $allGood = false;
        echo "❌ Mismatch in $modelClass (Table: $table):\n";
        echo "   Missing columns in database: " . implode(', ', $missingColumns) . "\n";
    } else {
        echo "✅ $modelClass is perfectly aligned with table '$table'.\n";
    }
}

if ($allGood) {
    echo "\n🎉 ALL MODELS MATCH THEIR TABLES PERFECTLY!\n";
} else {
    echo "\n⚠️ WAH, ADA KOLOM YANG KURANG DI DATABASE!\n";
}
