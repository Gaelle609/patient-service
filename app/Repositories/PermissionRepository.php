<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Tag;
use App\Repositories\BaseRepository;

class PermissionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'description'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Permission::class;
    }
}
