<?php

namespace App\Repositories;


use App\Models\Transfer;
use App\Repositories\BaseRepository;

class TransferRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'date_envoi',
        'date_recu',
       
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Transfer::class;
    }



}
