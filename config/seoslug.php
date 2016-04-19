<?php

return [
    // Spaces will be replaced with this delimiter,
    // available delimiters are '-' and '_'
    'delimiter' => '_',

    // 1 - '/категория/книги_в_москве'
    // 2 - '/kategoriya/knigi_v_moskve' - translit using Yandex rules
    'urlType' => 1,

    // Keep capital letters
    'keepCapitals' => false,

    // Name of a table column where slugs will be stored
    'slugColumnName' => 'slug'
];