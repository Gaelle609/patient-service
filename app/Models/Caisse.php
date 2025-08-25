<?php

namespace App\Models;

use App\Observers\CaisseObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([CaisseObserver::class])]  
class Caisse extends Model
{
    use HasFactory, SoftDeletes;

  protected $fillable = [
        'patient_id',
        'id_per',
        'motif',
        'total',
        'verser',
        'reste',
        'lettre',
        'etatCaisse',
    ];

    protected $casts = [
        'patient_id' => 'integer',
        'id_per'     => 'integer',
        'motif'      => 'string',
        'total'      => 'decimal:2',
        'verser'     => 'decimal:2',
        'reste'      => 'decimal:2',
        'lettre'     => 'string',
        'etatCaisse' => 'string',
    ];

    public static array $rules = [
        'patient_id' => 'required|integer|exists:patients,id',
        'id_per'     => 'required|integer',
        'motif'      => 'nullable|string',
        'total'      => 'nullable|numeric',
        'verser'     => 'nullable|numeric',
        'reste'      => 'nullable|numeric',
        'lettre'     => 'nullable|string',
        'etatCaisse' => 'nullable|string|in:attente,validé', 
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

     public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

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
