<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;

$tables = [
    'ticket_comments',
    'ticket_comment_attachments',
    'ticket_attachments',
];

foreach ($tables as $t) {
    echo $t . ': ' . (Schema::hasTable($t) ? 'exists' : 'missing') . PHP_EOL;
}

// If exists, show columns
if (Schema::hasTable('ticket_comment_attachments')) {
    $cols = Schema::getColumnListing('ticket_comment_attachments');
    echo "Columns: \n" . implode(", ", $cols) . PHP_EOL;
}

if (Schema::hasTable('ticket_comments')) {
    $cols = Schema::getColumnListing('ticket_comments');
    echo "ticket_comments Columns: \n" . implode(", ", $cols) . PHP_EOL;
}
