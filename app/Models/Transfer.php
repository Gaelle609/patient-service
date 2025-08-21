<?php

namespace App\Models;

use App\Observers\TransferObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([TransferObserver::class])]
class Transfer extends Model
{
    use HasFactory, SoftDeletes;

   protected $fillable = [
        'id_per_sender',
        'id_per_receiver',
        'date_envoi',
        'date_recu',
        'patient_id',
        'state',
        'id_per_recu',
    ];

    protected $casts = [
        'id_per_sender' => 'integer',
        'id_per_receiver' => 'integer',
        'date_envoi' => 'datetime',
        'date_recu' => 'datetime',
        'patient_id' => 'integer',
        'state' => 'string',
        'id_per_recu' => 'integer',
    ];

    public static array $rules = [
        'id_per_sender' => 'nullable|integer',
        'id_per_receiver' => 'nullable|integer',
        'date_envoi' => 'nullable|date_format:Y-m-d H:i:s',  
        'date_recu' => 'nullable|date_format:Y-m-d H:i:s', 
        'patient_id' => 'required|integer|exists:patients,id',
        'state' => 'nullable|string|in:non_recu,recu', 
        'id_per_recu' => 'nullable|integer',
    ];


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
   

    /*
    |--------------------------------------------------------------------------
    | ACTIONS
    |--------------------------------------------------------------------------
    */
    

     /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */



    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */



    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

}
