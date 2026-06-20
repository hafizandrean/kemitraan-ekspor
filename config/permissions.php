<?php

return [
    'roles' => ['admin', 'petani', 'eksportir'],

    'features' => [
        'upload_product' => ['admin', 'petani'],
        'unlimited_products' => ['admin', 'petani_premium'],
        'partnership_history' => ['admin', 'petani', 'eksportir'],
        'advance_partnership_stage' => ['admin', 'petani'],
        'upload_partnership_documents' => ['admin', 'petani', 'eksportir'],
        'rate_farmer' => ['admin', 'eksportir'],
        'view_exporter_contact' => ['admin', 'petani_premium', 'eksportir'],
        'priority_product_listing' => ['admin', 'petani_premium'],
        'market_insight' => ['admin', 'petani_premium', 'eksportir'],
        'direct_chat' => ['admin', 'petani_premium', 'eksportir'],
        'verify_premium_users' => ['admin'],
    ],

    'limits' => [
        'free_petani_max_products' => 5,
        'free_eksportir_daily_applications' => 3,
        'trusted_min_completed_partnerships' => 5,
        'trusted_min_rating' => 5,
    ],
];
