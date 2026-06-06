<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=u102361870_hotel;charset=utf8', 'u102361870_hotel', 'Warofdemon3@');

    // Show all cache keys
    $stmt = $pdo->query("SELECT `key`, expiration FROM `cache` WHERE `key` LIKE '%section%' OR `key` LIKE '%all_sections%'");
    echo "Found cache entries:\n";
    foreach ($stmt as $row) {
        echo '  - '.$row['key'].' (expires: '.$row['expiration'].")\n";
    }

    // Delete relevant cache
    $count = $pdo->exec("DELETE FROM `cache` WHERE `key` LIKE '%section%' OR `key` LIKE '%all_sections%'");
    echo "\nDeleted $count cache entries\n";

    // Also show total cache table size
    $total = $pdo->query('SELECT COUNT(*) FROM `cache`')->fetchColumn();
    echo "Remaining cache entries: $total\n";

} catch (Exception $e) {
    echo 'Error: '.$e->getMessage()."\n";
}
