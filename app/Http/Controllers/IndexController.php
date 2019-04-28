<?php

namespace App\Http\Controllers;

use App\Company;
use App\Vote;
use DB;

class IndexController extends Controller
{
    /**
     * @param string $categoryId Companies category identifier
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(int $categoryId = null)
    {
        $query = Company::query();

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $companies = $query->paginate(Company::ITEMS_PER_PAGE);

        $companyList = [];

        /* @var $company Company */
        foreach ($companies as $company) {
            $companyList[$company->id] = json_decode(json_encode($company), true);
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

        return view('index.index', [
            'companies' => $companyList,
            'categories' => Company::getCategories(),
            'votes' => $votesMap,
            'pagination' => $companies,
        ]);
    }
}
