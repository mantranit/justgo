<?php

Yii::setAlias('@uploads', __DIR__ . '/../../../uploads');

return [
    'adminEmail' => 'admin@example.com',
    'image_sizes' => [
        'thumbnail' => [240, 240],
        'thumbnail-search' => [100, 100],
        'thumbnail-slide' => [160, 160],
        'slide' => [400, 400],
        'feature-desktop' => [870, 400],
        'feature-phone' => [600, 600]
    ]
];
