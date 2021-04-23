<?php


namespace App\Repositories\User\MetaPricesRepository;


use App\Repositories\CoreDBRepository;

class UserMainMetaPricesRepository extends CoreDBRepository
{
    protected function getTableName()
    {
        return 'meta_price';
    }


    public function getPricesGroupByCompanyId($ids) {
        $data = $this->startConditions()
            ->select('*')
            ->whereIn('company_id', $ids)
            ->get();
        $metaPrices = collect([]);

        $data->each(function ($price) use ($metaPrices) {
            $key = $price->company_id;
            $value = $metaPrices->get($key) ?? [];
            array_push($value, $price);
            $metaPrices->put($key, $value);
        });
        return $metaPrices;
    }
}
