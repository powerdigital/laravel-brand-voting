<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'category_id', 'logo', 'description', 'votes'
    ];

    private const CATEGORIES = [
        1 => 'Свыше 200 чел',
        2 => 'От 100 до 200 чел',
        3 => 'От 50 до 100 чел',
        4 => 'От 20 до 50 чел',
        5 => 'До 20 чел',
    ];

    public const ITEMS_PER_PAGE = 6;

    /**
     * Flag to set if created/updates fields required.
     *
     * @var boolean
     */
    public $timestamps = null;

    public static function getCategories()
    {
        return self::CATEGORIES;
    }

    /**
     * Get companies list with attributes
     *
     * @param int $categoryId optional Company category identifier
     *
     * @return array The list of company attributes
     */
    public static function getCompanies(int $categoryId = null): array
    {
        $query = self::query();

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $companies = $query->paginate(self::ITEMS_PER_PAGE);

        $companyList = [];

        /* @var $company Company */
        foreach ($companies as $company) {
            $companyList[] = json_decode(json_encode($company), true);
        }

        return [
            'companies' => $companyList,
            'pagination' => $companies,
            'categories' => self::getCategories(),
        ];
    }
}
