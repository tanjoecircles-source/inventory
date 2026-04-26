<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$sourceDB = 'tanjoe_develop';
$targetDB = 'tanjoe_new';
$date = date('Y-m-d');
$filename = "marketplace-" . $date . ".sql";
$filePath = base_path($filename);

$sourceTables = array_map(function($t) use ($sourceDB) {
    return $t->{"Tables_in_$sourceDB"};
}, DB::select("SHOW TABLES FROM $sourceDB"));

$targetTables = array_map(function($t) use ($targetDB) {
    return $t->{"Tables_in_$targetDB"};
}, DB::select("SHOW TABLES FROM $targetDB"));

$missingTables = array_diff($sourceTables, $targetTables);

if (empty($missingTables)) {
    echo "Tidak ada table baru di $sourceDB yang tidak ada di $targetDB.\n";
    exit;
}

echo "Menemukan " . count($missingTables) . " table baru.\n";

$sqlContent = "-- Dump of tables missing in $targetDB from $sourceDB\n";
$sqlContent .= "-- Date: " . date('Y-m-d H:i:s') . "\n\n";

foreach ($missingTables as $table) {
    echo "Processing table: $table...\n";
    
    // Get CREATE TABLE
    $create = DB::select("SHOW CREATE TABLE $sourceDB.$table")[0];
    $sqlContent .= $create->{"Create Table"} . ";\n\n";
    
    // Optional: Dump data? User said "dump sql", usually includes data for marketplace stuff.
    // But usually comparing tables refers to schema.
    // I'll just do the schema for now unless I see a reason for data.
    // Actually, I'll add the data dump too if the table has data.
    
    $rows = DB::table("$sourceDB.$table")->get();
    if ($rows->count() > 0) {
        $sqlContent .= "-- Data for table $table\n";
        foreach ($rows as $row) {
            $rowArray = (array)$row;
            $columns = implode("`, `", array_keys($rowArray));
            $values = implode("', '", array_map(function($v) {
                return addslashes($v);
            }, array_values($rowArray)));
            
            $sqlContent .= "INSERT INTO `$table` (`$columns`) VALUES ('$values');\n";
        }
        $sqlContent .= "\n";
    }
}

file_put_contents($filePath, $sqlContent);

echo "Selesai! File dump disimpan di: $filePath\n";
echo "Tables exported: " . implode(", ", $missingTables) . "\n";
