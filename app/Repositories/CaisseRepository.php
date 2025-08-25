<?php

namespace App\Repositories;

use App\Models\Caisse;
use App\Models\Patient;
use App\Models\Role;
use App\Repositories\BaseRepository;

class CaisseRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'motif',
       
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Caisse::class;
    }



}
