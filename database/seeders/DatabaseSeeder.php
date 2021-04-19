<?php

namespace Database\Seeders;

use App\Repositories\Seeder\ImportDBRepository;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @param ImportDBRepository $repository
     * @return void
     * @throws \Exception
     */
    public function run(ImportDBRepository $repository)
    {
        $data = $repository->getDBDump();

        $repository->storeCompany($data['company']);
        $repository->storeReviews($data['reviews']);
        $repository->storeUsers($data['users']);
        $repository->storeVideos($data['videos']);
        $repository->storeEstimates($data['estimates']);
        $repository->storeMetaPrice($data['meta_price']);
        // !!! Теряем первое значение
        $repository->storeEstimatesMeta($data['estimatesMeta']);
    }
}
