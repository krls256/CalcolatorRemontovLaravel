<?php


namespace App\Services\User;


use App\Services\CoreService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProfessionalCalculatorDataService extends CoreService
{
    private $request;

    public function __construct(Request $request) { $this->request = $request; }

    public function run($params = null)
    {
        $data = [];
        $request = $this->request->all();
        unset($request['all']);
        foreach ($request as $key => $value)
            $data[$key] = (gettype($value) == 'array') ? array_values($value) : $value;

        return collect($data);
    }

}
