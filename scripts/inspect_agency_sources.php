<?php
$paths = [
    __DIR__ . '/../database/seeders/data/agency.csv',
    __DIR__ . '/../database/seeders/data/agency2.csv',
];
foreach ($paths as $p) {
    if (file_exists($p)) {
        echo basename($p) . ' lines: ' . count(file($p)) . PHP_EOL;
    } else {
        echo basename($p) . " not found\n";
    }
}

// Bootstrap Laravel and count DB rows
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $count = DB::table('agency')->count();
    echo "DB agency rows: $count\n";
    $distinct = DB::table('agency')->distinct('group_code')->count('group_code');
    echo "DB distinct group_code: $distinct\n";
    $sample = DB::table('agency')->select('group_code')->orderBy('id','desc')->limit(10)->get()->pluck('group_code')->toArray();
    echo "Last 10 group_code: " . implode(', ', $sample) . PHP_EOL;
} catch (\Throwable $e) {
    echo 'DB check failed: ' . $e->getMessage() . PHP_EOL;
}
