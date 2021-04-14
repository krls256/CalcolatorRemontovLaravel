<?php


namespace App\Repositories\Seeder;


//use App\Repositories\CoreRepository;
use App\Models\User;
use App\Repositories\CoreRepository;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ImportRepository extends CoreRepository
{
    protected function getTableName() { return 'company'; }

    /** @return Collection
     * @throws Exception
     */
    public function getDBDump()
    {
        $dumpDisk = 'resources';
        $dumpFile = 'files_for_db/dump.json';
        try
        {
            $json = collect(json_decode(Storage::disk($dumpDisk)
                ->get($dumpFile), true));
        } catch (Exception $e)
        {
            throw new Exception("Файла $dumpFile не существует " . __METHOD__);
        }
        $newJson = collect();

        $json->each(function ($dumpItem) use ($newJson)
        {
            if (($dumpItem['type'] ?? '') === 'table')
            {
                $newJson->put($dumpItem['name'], $dumpItem['data']);
            }
        });
        return $this->prepareFileImport($newJson);
    }

    public function storeVideos($videos)
    {
        $companies = $this->getCompaniesIds();

        $this->juxtaposeFromArray($videos, $companies, 'company_id', 'company_name');
        $this->unsetArrayFieldForEach($videos, 'company_name');
        $this->changeTable('videos');

        $this->startConditions()
            ->insert($videos);
    }

    /**
     * @param array $companies
     * @return bool
     */
    public function storeCompany($companies)
    {
        $this->changeTable('company');

        return $this->startConditions()
            ->insert($companies);
    }

    public function storeReviews($reviews)
    {
        $companies = $this->getCompaniesIds();

        $this->juxtaposeFromArray($reviews, $companies, 'company', 'company_name');
        $this->unsetArrayFieldForEach($reviews, 'company_name');
        $this->changeTable('reviews');
        $perInsert = 350;
        while (count($reviews) > 0)
        {
            $res = $this->startConditions()
                ->insert(array_splice($reviews, 0, $perInsert));
        }
        return $res;
    }

    public function storeUsers($users)
    {
        foreach ($users as $user)
        {
            User::create($user);
        }
    }


    public function storeEstimates($estimates)
    {
        $companies = $this->getCompaniesIds();

        $this->juxtaposeFromArray($estimates, $companies, 'company_id', 'company_name');
        $this->unsetArrayFieldForEach($estimates, 'company_name');
        $this->changeTable('estimates');

        return $this->startConditions()
            ->insert($estimates);
    }

    public function storeMetaPrice($meta_price)
    {
        $companies = $this->getCompaniesIds();

        $this->juxtaposeFromArray($meta_price, $companies, 'company_id', 'company_name');
        $this->unsetArrayFieldForEach($meta_price, 'company_name');
        $this->changeTable('meta_price');

        return $this->startConditions()
            ->insert($meta_price);
    }

    public function storeEstimatesMeta($estimatesMeta)
    {
        $estimates = $this->getEstimatesIds();
        $this->juxtaposeFromArray($estimatesMeta, $estimates, 'estimate_id', 'company_name');
        $this->unsetArrayFieldForEach($estimatesMeta, 'company_name');

        $this->changeTable('estimatesMeta');
        $this->startConditions()->insert($estimatesMeta);
    }

    private function prepareFileImport(Collection $newJson)
    {
        // Companies
        $companies = $newJson->get('company');
        $companiesIdNameArray = [];
        foreach ($companies as $v)
        {
            $companiesIdNameArray[$v['id']] = $v['name'];
        }
        $this->unsetArrayFieldForEach($companies, 'id');
        $newJson->put('company', $companies);

        // Reviews
        $reviews = $newJson->get('reviews');
        $this->juxtaposeFromArray($reviews, $companiesIdNameArray, 'company_name', 'company');
        $this->unsetArrayFieldForEach($reviews, 'id');
        $this->unsetArrayFieldForEach($reviews, 'company');
        $newJson->put('reviews', $reviews);

        // Users
        $users = $newJson->get('users');
        $this->unsetArrayFieldForEach($users, 'id');
        $newJson->put('users', $users);

        // Videos

        $videos = $newJson->get('videos');
        $this->juxtaposeFromArray($videos, $companiesIdNameArray, 'company_name', 'company_id');
        $this->unsetArrayFieldForEach($videos, 'id');
        $this->unsetArrayFieldForEach($videos, 'company_id');
        $newJson->put('videos', $videos);

        // Estimates
        $estimates = $newJson->get('estimates');
        $estimatesIdCompanyNameArray = [];
        foreach ($estimates as $v)
        {
            $estimatesIdCompanyNameArray[$v['id']] = $v['name'];
        }
        $this->juxtaposeFromArray($estimates, $companiesIdNameArray, 'company_name', 'company_id');
        $this->unsetArrayFieldForEach($estimates, 'id');
        $this->unsetArrayFieldForEach($estimates, 'company_id');
        $newJson->put('estimates', $estimates);

        // Estimates Meta
        $estimatesMeta = $newJson->get('estimatesMeta');
        $this
            ->juxtaposeFromArray($estimatesMeta, $estimatesIdCompanyNameArray, 'company_name', 'estimate_id', true);
        $this->unsetArrayFieldForEach($estimatesMeta, 'id');
        $this->unsetArrayFieldForEach($estimatesMeta, 'estimate_id');

        $newJson->put('estimatesMeta', $estimatesMeta);
        // Meta price
        $meta_price = $newJson->get('meta_price');
        $this->juxtaposeFromArray($meta_price, $companiesIdNameArray, 'company_name', 'company_id');
        $this->unsetArrayFieldForEach($meta_price, 'id');
        $this->unsetArrayFieldForEach($meta_price, 'company_id');
        $newJson->put('meta_price', $meta_price);

        return $newJson;
    }

    private function unsetArrayFieldForEach(&$array, $field)
    {
        foreach ($array as $k => $v)
        {
            unset($array[$k][$field]);
        }
    }

    private function juxtaposeFromArray(&$coreArray, &$juxtaposeArray, $coreField, $juxField, $removeUnknown = false)
    {
        if($removeUnknown) {
            $col = collect($coreArray);
            $col = $col->filter(function ($item) use ($juxField, $juxtaposeArray) {
                return isset($juxtaposeArray[$item[$juxField]]);
            })->values();
            $coreArray = $col->toArray();
        }
        foreach ($coreArray as $k => $v)
        {
            $coreArray[$k][$coreField] = $juxtaposeArray[$coreArray[$k][$juxField]];
        }
    }

    private function getCompaniesIds()
    {
        $this->changeTable('company');
        return $this->startConditions()
            ->select(['id', 'name'])
            ->get()
            ->keyBy('name')
            ->map(function ($i) { return $i->id; });
    }

    private function getEstimatesIds()
    {
        $this->changeTable('estimates');
        $res = $this->startConditions()
            ->select(['id', 'name'])
            ->get()
            ->keyBy('name')
            ->map(function ($i) { return $i->id; });
        return $res;
    }
}
