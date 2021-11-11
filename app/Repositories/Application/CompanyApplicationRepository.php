<?php

namespace App\Repositories\Application;

use App\Repositories\CoreDBRepository;

class CompanyApplicationRepository extends CoreDBRepository {
    protected function getTableName() {
        return 'company';
    }

    public function getCompanyEmail($id) {
        $company = $this->startConditions()
        ->where('id', $id)
        ->first();
        if($company) {
            return $company->email;
        }
        return null;
    }
}
