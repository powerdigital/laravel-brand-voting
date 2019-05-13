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
        1 => '> 200 чел',
        2 => '100 - 199 чел',
        3 => '50 - 99 чел',
        4 => '20 - 49 чел',
        5 => '< 20 чел',
    ];

    public const ITEMS_PER_PAGE = 9;

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

//        $companies = $query->paginate(self::ITEMS_PER_PAGE);
        $companies = $query->get();

        $companyList = [];

        /* @var $company Company */
        foreach ($companies as $company) {
            $companyList[] = json_decode(json_encode($company), true);
        }

        return [
            'categoryId' => $categoryId,
            'companies' => $companyList,
            'pagination' => $companies,
            'categories' => self::getCategories(),
        ];
    }
}
