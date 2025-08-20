<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientRequest;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Patient;
use App\Repositories\PatientRepository;
use App\Traits\ConsumesExternalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\RequestException;

class PatientController extends AppBaseController
{
    use ConsumesExternalService;


    
    public function __construct(private PatientRepository $patientRepository)
    {
       
    }

    public function index()
    {
       
        $patients = $this->patientRepository->getAll();

        return $this->sendResponse(
            ["patients" => $patients],
            __('messages.retrieved', ['model' => __('models/patients.plural')])
        );
    }

     public function store(StorePatientRequest $request)
    {
        $input = $request->validated();
    
        $paient = $this->patientRepository->create($input);
        
        return $this->sendResponse(
            ["patien" => $paient],
            __('messages.saved', ['model' => __('models/patient.singular')])
        );
    
    }
   
    public function show(Patient $patient)
    {
          return $this->sendResponse(
            ["patient" => $patient],
            __('messages.retrieved', ['model' => __('models/patient.singular')])
        );
    }

    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        $input = $request->validated();
        $patient = $this->patientRepository->update($input, $patient->id);

        return $this->sendResponse(
            ["patient" => $patient],
            __('messages.updated', ['model' => __('models/patient.singular')])
        );
    }
    
    public function destroy(Patient $patient)
    {
        $this->patientRepository->delete($patient->id);

        return $this->sendResponse(
            [],
            __('messages.deleted', ['model' => __('models/patient.singular')])
        );
    }
   


   
}
