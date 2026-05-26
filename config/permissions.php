<?php

return [
    'roles' => ['admin', 'farmer', 'exporter'],

    'features' => [
        'upload_product' => ['admin', 'farmer'],
        'unlimited_products' => ['admin', 'farmer_premium'],
        'partnership_history' => ['admin', 'farmer', 'exporter'],
        'advance_partnership_stage' => ['admin', 'farmer'],
        'upload_partnership_documents' => ['admin', 'farmer', 'exporter'],
        'rate_farmer' => ['admin', 'exporter'],
        'view_exporter_contact' => ['admin', 'farmer_premium', 'exporter'],
        'priority_product_listing' => ['admin', 'farmer_premium'],
        'market_insight' => ['admin', 'farmer_premium', 'exporter'],
        'direct_chat' => ['admin', 'farmer_premium', 'exporter'],
        'verify_premium_users' => ['admin'],
    ],

    'limits' => [
        'free_farmer_max_products' => 5,
        'free_exporter_daily_applications' => 3,
        'trusted_min_completed_partnerships' => 5,
        'trusted_min_rating' => 5,
    ],
];
