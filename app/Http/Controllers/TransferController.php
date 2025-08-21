<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransferRequest;
use App\Http\Requests\UpdateTransferRequest;
use App\Models\Transfer;
use App\Repositories\TransferRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class TransferController extends AppBaseController
{
   public function __construct(private TransferRepository $transferRepository)
    {}

    public function index()
    {
       
        $transfers = $this->transferRepository->getAll();

        return $this->sendResponse(
            ["services" => $transfers],
            __('messages.retrieved', ['model' => __('models/transerfer.plural')])
        );
    }

     public function store(StoreTransferRequest $request)
    {
        $input = $request->all();
   
        $authUser = $request->user();
        $input['id_per_sender'] = $authUser->getAuthIdentifier();
        $input['date_envoi']=now();
        //  dd($input);
        $transfer = $this->transferRepository->create($input);
        
        return $this->sendResponse(
            ["transfer" => $transfer],
            __('messages.saved', ['model' => __('models/services.singular')])
        );
    
    }
   
    public function show(Transfer $transfer)
    {
          return $this->sendResponse(
            ["transfer" => $transfer],
            __('messages.retrieved', ['model' => __('models/transfer.singular')])
        );
    }

    public function update(UpdateTransferRequest $request, Transfer $transfer)
    {
        $input = $request->validated();
        $transfer = $this->transferRepository->update($input, $transfer->id);

        return $this->sendResponse(
            ["transfer" => $transfer],
            __('messages.updated', ['model' => __('models/transfer.singular')])
        );
    }
    
    public function destroy(Transfer $transfer)
    {
        $this->transferRepository->delete($transfer->id);

        return $this->sendResponse(
            [],
            __('messages.deleted', ['model' => __('models/transfer.singular')])
        );
    }
}
