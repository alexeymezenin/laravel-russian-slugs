<?php

return [
    // 1 - '/категория/книги_в_москве'
    // 2 - '/kategoriya/knigi-v-moskve' - translit using Yandex rules
    'urlType' => 1,
    
    // Keep capitals or not.
    // false - '/kategoriya/knigi-v-moskve'
    // true - '/Kategoriya/Knigi-v-Moskve'
    'keepCapitals' => false,

    // Spaces will be replaced with this delimiter
    'delimiter' => '_',

    // Name of a table column where slugs will be stored
    'slugColumnName' => 'slug'
];