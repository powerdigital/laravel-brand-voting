<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    private const CATEGORIES = [
        1 => 'Свыше 200 чел',
        2 => 'От 100 до 200 чел',
        3 => 'От 50 до 100 чел',
        4 => 'От 20 до 50 чел',
        5 => 'До 20 чел',
    ];

    public const ITEMS_PER_PAGE = 6;

    public static function getCategories()
    {
        return self::CATEGORIES;
    }
}
