<?php


namespace App\Repositories\User\CompanyRepository;


use App\Repositories\CoreDBRepository;
use App\Repositories\User\MetaPricesRepository\UserMainMetaPricesRepository;
use App\Repositories\User\ReviewsRepository\MainUserReviewsRepository;
use App\Storage\AppConstants;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use stdClass;

class MainUserCompaniesRepository extends CoreDBRepository
{
    protected function getTableName()
    {
        return 'company';
    }

    public function getRatingCompaniesLimit($limit = 6)
    {
        $homeRating = $this->coreGetRatingCompanies()
            ->limit($limit)
            ->get();

        return $homeRating;
    }

    /**
     * @return Collection
     */

    public function getRatingCompaniesTop()
    {
        $companiesTop = $this->coreGetRatingCompanies()
            ->get();
        return $companiesTop;
    }

    /**
     * @return Collection
     */

    public function getRatingCompaniesTopWithCount()
    {
        $companiesTop = $this->startConditions()
            ->select('*', DB::raw('(`rating_profile` + `rating_reviews`)/2 as `ratingSort`'))
            ->orderBy('ratingSort', "DESC")->get();

        $ids = $companiesTop->map(function ($company) { return $company->id; });
        $reviewRepository = new MainUserReviewsRepository();

        $counts = $reviewRepository->getCountsByIds($ids->toArray());

        $companiesTop->transform(function ($company) use ($counts) {
            $company->count = $counts[$company->id] ?? 0;
            return $company;
        });

        return $companiesTop;
    }

    /**
     * @return stdClass
     */

    public function getSuperCompany() {
        $superCompany = $this->startConditions()
            ->where('name', AppConstants::MAIN_COMPANY_NAME)
            ->first();
        return $superCompany;
    }

    /**
     * @param $top
     * @return stdClass
     */

    public function getSuperCompanyFromTop($top) {
        $superCompany = $top
            ->where('name', AppConstants::MAIN_COMPANY_NAME)
            ->first();

        return $superCompany;
    }

    public function getCompaniesWithPrices() {
        $companies = $this->startConditions()
            ->select('*', DB::raw('(`rating_profile` + `rating_reviews`)/2 as `ratingSort`'))
            ->orderBy('ratingSort', "DESC")
            ->get();
        $ids = $companies->map(function ($company) {return $company->id;})->toArray();
        $metaPriceRepository = new UserMainMetaPricesRepository();
        $metaPrices = $metaPriceRepository->getPricesGroupByCompanyId($ids);
        $companies->transform(function ($company) use ($metaPrices) {

            $company->priceList = $metaPrices[$company->id];
            return $company;
        });

        return $companies;
    }

    public function getCompaniesInArr($ids) {
        return $this->startConditions()
            ->whereIn('id', $ids)
            ->get();
    }

    /**
     *
     * @return Builder
     */
    protected function coreGetRatingCompanies()
    {
        $builder = $this->startConditions()
            ->select('*', DB::raw('(`rating_profile` + `rating_reviews`)/2 as `ratingSort`'))
            ->orderBy('ratingSort', "DESC");

        return ($builder);
    }

}
