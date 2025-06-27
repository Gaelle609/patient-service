<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientRequest;
use App\Models\Patient;
use App\Repositories\PatientRepository;
use App\Traits\ConsumesExternalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\RequestException;

class PatientController extends AppBaseController
{
    use ConsumesExternalService;

    protected $baseUri;
    
    public function __construct(private PatientRepository $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }
    public function create(PatientRequest $request)
    {
        // $this->authorize('create', Patient::class);
    $input = $request->all();
   
    $user = $this->patientRepository->create($input);
     
    return $this->sendResponse(
        ["user" => $user->fresh()],
        __('messages.saved', ['model' => __('models/users.singular')])
    );
   
    }


    public function show(PatientRequest $request)
    {
        dd('hgdhs');
    }
}
