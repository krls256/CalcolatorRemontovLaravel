<?php


namespace App\Repositories\User\VideosRepository;


use App\Repositories\CoreDBRepository;
use App\Repositories\User\CompanyRepository\MainUserCompaniesRepository;
use Illuminate\Support\Facades\DB;

class MainUserVideosRepository extends CoreDBRepository
{
    protected function getTableName()
    {
        return 'videos';
    }

    public function getCompaniesVideos() {
        $videos = $this->startConditions()
            ->get();

        $gropedVideos = collect();

        $videos->each(function ($video) use ($gropedVideos) {
            $key = $video->company_id;
            $value = $gropedVideos->get($key) ?? [];
            array_push($value, $video);
            $gropedVideos->put($key, $value);
        });
        $ids = $gropedVideos->keys()->toArray();

        $companiesRepository = new MainUserCompaniesRepository();
        $companies = $companiesRepository->getCompaniesInArr($ids);

        $companies->transform(function ($company) use ($gropedVideos) {
           $company->video = $gropedVideos[$company->id];
           return $company;
        });

        return $companies;

    }
}
