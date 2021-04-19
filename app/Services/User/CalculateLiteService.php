<?php


namespace App\Services\User;


use App\Repositories\Services\CalculatorServiceRepository;
use App\Services\CoreService;
use App\Services\User\Traits\CalculateCountingTrait;
use App\Storage\CalculatorConstants;
use Illuminate\Http\Request;

class CalculateLiteService extends CoreService
{
    use CalculateCountingTrait;

    private $repository;
    private $request;
    private $estimatesMeta;
    private $calculatorConstants;

    public function __construct(
        CalculatorServiceRepository $repository,
        Request $request,
        CalculatorConstants $calculatorConstants
    )
    {
        $this->repository = $repository;
        $this->calculatorConstants = $calculatorConstants;
        $this->request = $request;
    }

    public function run($calcPattern = null)
    {
        $companies = $this->repository->getCompaniesForCalculator();
        $ids = $companies->map(function ($company) {return $company->estimate_id;})->toArray();

        $estimatesMeta = $this->repository->getEstimatesMetaForCalculator($ids)
            ->keyBy(function ($meta) {return $this->createEstimateKey([$meta->estimate_id, $meta->type, $meta->name]);});

        $this->estimatesMeta = $estimatesMeta;
        return $this->mapData($companies, $calcPattern);

    }

    private function mapData($companies, $calcPattern)
    {
        $companies = $companies->map(function ($company) use ($calcPattern)
        {
            $company->details = [];
            $calcPattern->each(function ($pattern, $roomType) use ($company)
            {
                $this->calculatorConstants->roomType = $roomType;
                $calculatedRoomType = $this->calculatePattern($pattern, $company->estimate_id);
                $company->details[$roomType] = $calculatedRoomType;


            });
            $company->price = $this->calcTotalPrice($company->details);
            return (array) $company;
        });
        return $companies;
    }

    private function calculatePattern($pattern, $estimate_id, $with_key = true)
    {
        $calculatedPattern = [];
        $this->resetPattern($pattern);

        foreach ($pattern as $type => $name)
        {
            if (gettype($name) === 'array')
            {
                $is_still = !($type === 'still');
                $calculatedPattern[$type] = $this->calculatePattern($name, $estimate_id, $is_still);
            } else
            {
                $estimateItem = $this->estimatesMeta->get($this->createEstimateKey([$estimate_id, $type, $name])) ??
                    $this->estimatesMeta->get($this->createEstimateKey([$estimate_id, $name, $type]));

                if ($estimateItem !== null)
                {
                    // TODO: find a way to be without $with_key param
                    if($with_key)
                        $calculatedPattern[$type] = $this->calculatePrice($estimateItem);
                    else
                        $calculatedPattern[] = $this->calculatePrice($estimateItem);
                }
                // TODO: add logic on null
            }
        }
        return $calculatedPattern;
    }

    protected function getCalculatorConstants()
    {
        return $this->calculatorConstants;
    }
    private function createEstimateKey($arr)
    {
        return implode('%', $arr);
    }
}
