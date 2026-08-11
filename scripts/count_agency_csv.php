<?php
$path = __DIR__ . '/../database/seeders/data/agency.csv';
if (!file_exists($path)) { echo "File not found: $path\n"; exit(1); }
$handle = fopen($path, 'r');
$header = fgetcsv($handle);
$total = 0;
$deleted = 0;
$blankGroup = 0;
$groupCodes = [];
$duplicates = [];
while (($row = fgetcsv($handle, 10000, ",")) !== false) {
    $total++;
    $groupCode = isset($row[1]) ? trim($row[1]) : '';
    $deletedFlag = isset($row[11]) ? (int)$row[11] : 0;
    if ($deletedFlag === 1) {
        $deleted++;
        continue;
    }
    if ($groupCode === '') {
        $blankGroup++;
        continue;
    }
    if (isset($groupCodes[$groupCode])) {
        $duplicates[$groupCode] = ($duplicates[$groupCode] ?? 1) + 1;
    } else {
        $groupCodes[$groupCode] = 1;
    }
}
fclose($handle);
$distinct = count($groupCodes);
arsort($duplicates);
echo "CSV total rows (excluding header): $total\n";
echo "Deleted rows (DELETED=1): $deleted\n";
echo "Blank group_code rows (non-deleted): $blankGroup\n";
echo "Distinct non-deleted group_code count: $distinct\n";
$top = array_slice($duplicates, 0, 10, true);
if ($top) {
    echo "Top duplicates (group_code => occurrences):\n";
    foreach ($top as $k=>$v) { echo "  $k => $v\n"; }
}
