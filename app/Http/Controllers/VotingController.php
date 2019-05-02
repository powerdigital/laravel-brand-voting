<?php

namespace App\Http\Controllers;

use App\Company;
use App\Vote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class VotingController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function add()
    {
        $userId = Auth::id();

        if (null === $userId) {
            return response()->json([
                'success' => false,
                'message' => 'Для голосования необходимо авторизовать в системе'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $companyId = (int)request()->get('company_id');
        $categoryId = Company::select('category_id')->where('id', $companyId)->get()->first()->category_id;

        $count = DB::table('votes')
            ->select(DB::raw('count(votes.id) as count'))
            ->join('companies', 'companies.id', '=', 'votes.company_id')
            ->where(['votes.user_id' => $userId, 'companies.category_id' => $categoryId])->first();

        $count = $count->count ?? 0;

        if ($count >= 3) {
            return response()->json([
                'success' => false,
                'message' => 'Вы уже использовали максимально допустимое количество голосов(3) в данной категории'
            ]);
        }

        $votes = Vote::where(['user_id' => $userId, 'company_id' => $companyId])->get()->count();

        if ($votes > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Вы уже отдали свой голос за данную компанию'
            ]);
        }

        DB::transaction(function () use ($userId, $companyId) {
            Vote::create(['user_id' => $userId, 'company_id' => $companyId]);
            Company::where('id', $companyId)->increment('votes');
        });

        return response()->json([
            'success' => true,
            'message' => 'Спасибо, Ваш голос засчитан за компанию!'
        ]);
    }
}
