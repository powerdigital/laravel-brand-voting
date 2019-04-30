<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

        $votes = DB::table('votes')
            ->select('company_id', DB::raw('count(*) as total'))
            ->whereIn('company_id', array_keys($companyList))
            ->groupBy('company_id')
            ->get();

        $votesMap = [];

        /* @var $vote Vote */
        foreach ($votes as $vote) {
            $votesMap[$vote->company_id] = $vote->total;
        }

        return [
            'companies' => $companyList,
            'votes' => $votesMap,
            'pagination' => $companies,
            'categories' => self::getCategories(),
        ];
    }
}
