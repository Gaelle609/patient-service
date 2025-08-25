<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCaisseRequest;
use App\Http\Requests\UpdatedCaisseRequest;
use App\Models\Caisse;
use App\Repositories\CaisseRepository;
use Illuminate\Http\Request;

class CaisseController extends Controller
{
     public function __construct(private CaisseRepository $caisseRepository)
    {}

    public function index()
    {
       
        $caisse = $this->caisseRepository->getAll();

        return $this->sendResponse(
            ["caisse" => $caisse],
            __('messages.retrieved', ['model' => __('models/caisse.plural')])
        );
    }

     public function store(StoreCaisseRequest $request)
    {
         $input = $request->all();
        $authUser = $request->user();
        $input['id_per'] = $authUser->getAuthIdentifier();
        // dd($input);
        $caisse = $this->caisseRepository->create($input);
        
        return $this->sendResponse(
            ["service" => $caisse],
            __('messages.saved', ['model' => __('models/services.singular')])
        );
    
    }
   
    public function show(Caisse $caisse)
    {
          return $this->sendResponse(
            ["service" => $caisse],
            __('messages.retrieved', ['model' => __('models/service.singular')])
        );
    }

    public function update(UpdatedCaisseRequest $request, Caisse $caisse)
    {
        $input = $request->validated();
        $caisse = $this->caisseRepository->update($input, $caisse->id);

        return $this->sendResponse(
            ["service" => $caisse],
            __('messages.updated', ['model' => __('models/service.singular')])
        );
    }
    
    public function destroy(Caisse $caisse)
    {
        $this->caisseRepository->delete($caisse->id);

        return $this->sendResponse(
            [],
            __('messages.deleted', ['model' => __('models/service.singular')])
        );
    }
}
