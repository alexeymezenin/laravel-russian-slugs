<?php

return [
    // 1 - '/категория/книги_в_москве'
    // 2 - '/Категория/Книги_в_Москве'
    // 3 - '/kategoriya/' - translit using Yandex rules
    'urlType' => 3,

    // Spaces will be replaced with this delimiter
    'delimiter' => '-',

    // Name of a table column where slugs will be stored
    'slugColumnName' => 'slug'
];