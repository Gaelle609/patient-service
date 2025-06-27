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

//     public function createPatient($data, $token)
// {
    
//         // Vérifier l'authentification auprès du service
//         $response = $this->performRequest('GET', '/api/users', [], [
//             'Authorization' => "Bearer $token"
//         ]);

//         // Vérifier si l'authentification a échoué
//         if (!is_array($response) || isset($response['error'])) {
//             return [
//                 'error' => true,
//                 'message' => 'Utilisateur non authentifié'
//             ];
//         }

//         // Créer le patient et retourner ses données
//         return Patient::create($data);
// }

}
