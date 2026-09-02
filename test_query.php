<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$request = new \Illuminate\Http\Request([
    'q' => 'ngaji',
    'date' => 'today',
    'audience' => 'ikhwan'
]);

$query = \App\Models\Kajian::query()->where('status', 'published');

if (!$request->filled('date') && !$request->filled('month')) {
    $query->where(function($q) {
        $q->where('start_at', '>=', now())
            ->orWhere(function($subQ) {
                $subQ->where('start_at', '<=', now())
                    ->where('end_at', '>=', now());
            });
    });
}

if ($request->filled('date')) {
    $date = $request->date;
    if ($date === 'today') {
        $query->whereBetween('start_at', [now()->startOfDay(), now()->endOfDay()]);
    }
}

if ($request->filled('audience')) {
    if (in_array($request->audience, ['ikhwan', 'akhwat'])) {
        $query->whereIn('audience', [$request->audience, 'umum']);
    } else {
        $query->where('audience', $request->audience);
    }
}

if ($request->filled('q')) {
    $q = $request->q;
    $query->where(function ($subQ) use ($q) {
        $subQ->where('title', 'like', "%{$q}%")
                ->orWhere('description', 'like', "%{$q}%");
    });
}

echo "SQL: " . $query->toSql() . "\n";
echo "Bindings: " . json_encode($query->getBindings()) . "\n";
echo "Result Count: " . $query->count() . "\n";
echo "Results: " . json_encode($query->pluck('title'), JSON_PRETTY_PRINT) . "\n";
