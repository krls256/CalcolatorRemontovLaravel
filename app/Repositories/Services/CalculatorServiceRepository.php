<?php


namespace App\Repositories\Services;


use App\Repositories\CoreDBRepository;

class CalculatorServiceRepository extends CoreDBRepository
{
    protected function getTableName()
    {
       return 'company';
    }


    public function getCompaniesForCalculator() {
        $this->changeTable('estimates as es');

        $column = ['es.id as estimate_id', 'es.company_id', 'cp.id as id', 'cp.url as url', 'cp.name as name', 'cp.logo as img', 'danger_level', 'danger_reason'];

        $calcResponse = $this->startConditions()
            ->select($column)
            ->join('company as cp', 'cp.id', '=', 'es.company_id')
            ->get();

        return $calcResponse;
    }

    public function getEstimatesMetaForCalculator($ids) {
        $this->changeTable('estimatesMeta');
        $column = ['id', 'name', 'type', 'meta', 'estimate_id', 'dimension'];

        $estimatesMeta = $this->startConditions()
            ->select($column)
            ->whereIn('estimate_id', $ids)
            ->get();

        return $estimatesMeta;
    }
}
