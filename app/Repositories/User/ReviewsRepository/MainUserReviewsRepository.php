<?php


namespace App\Repositories\User\ReviewsRepository;


use App\Repositories\CoreDBRepository;
use Illuminate\Support\Facades\DB;

class MainUserReviewsRepository extends CoreDBRepository
{
    protected function getTableName()
    {
        return 'reviews';
    }

    public function getCountsByIds($ids)
    {
        $counts = $this->startConditions()
            ->select('company', DB::raw('count(*) as count'))
            ->whereIn('company', $ids)
            ->groupBy('company')
            ->get()
            ->keyBy('company')
            ->map(function ($c) {return $c->count;});
        return $counts;
    }
}
