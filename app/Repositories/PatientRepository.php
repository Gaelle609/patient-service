<?php

namespace App\Repositories;

use App\Models\Patient;
use App\Models\Role;
use App\Repositories\BaseRepository;

class PatientRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'first_name',
        'last_name',
        'phone',
        'address',
       
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Patient::class;
    }



}
