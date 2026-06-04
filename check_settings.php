<?php

use App\Models\WebsiteSetting;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$settings = WebsiteSetting::where('group', 'payment')->get();
foreach ($settings as $s) {
    echo "{$s->key}: {$s->value}\n";
}
