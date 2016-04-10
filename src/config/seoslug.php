<?php

return [
    // 1 - '/категория/книги_в_москве'
    // 2 - '/kategoriya/knigi_v_moskve - translit using Yandex rules
    'urlType' => 2,

    // Keep capital letters
    'keepCapitals' => false,

    // Spaces will be replaced with this delimiter
    'delimiter' => '_',

    // Name of a table column where slugs will be stored
    'slugColumnName' => 'slug'
];