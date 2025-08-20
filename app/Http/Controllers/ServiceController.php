<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdatedServiceRequest;
use App\Models\Service;
use App\Repositories\ServiceRepository;
use Illuminate\Http\Request;

class ServiceController extends AppBaseController
{
      public function __construct(private ServiceRepository $serviceRepository)
    {}

    public function index()
    {
       
        $services = $this->serviceRepository->getAll();

        return $this->sendResponse(
            ["services" => $services],
            __('messages.retrieved', ['model' => __('models/services.plural')])
        );
    }

     public function store(StoreServiceRequest $request)
    {
        $input = $request->validated();
        // dd($input);
        $service = $this->serviceRepository->create($input);
        
        return $this->sendResponse(
            ["service" => $service],
            __('messages.saved', ['model' => __('models/services.singular')])
        );
    
    }
   
    public function show(Service $service)
    {
          return $this->sendResponse(
            ["service" => $service],
            __('messages.retrieved', ['model' => __('models/service.singular')])
        );
    }

    public function update(UpdatedServiceRequest $request, Service $service)
    {
        $input = $request->validated();
        $service = $this->serviceRepository->update($input, $service->id);

        return $this->sendResponse(
            ["service" => $service],
            __('messages.updated', ['model' => __('models/service.singular')])
        );
    }
    
    public function destroy(Service $service)
    {
        $this->serviceRepository->delete($service->id);

        return $this->sendResponse(
            [],
            __('messages.deleted', ['model' => __('models/service.singular')])
        );
    }
}
