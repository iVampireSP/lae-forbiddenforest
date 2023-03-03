<?php

$enabled = config('app.env') === 'production';

return [
    'cache-prefix' => 'model_cache_',

    'enabled' => $enabled,

    'use-database-keying' => env('MODEL_CACHE_USE_DATABASE_KEYING', true),
];
