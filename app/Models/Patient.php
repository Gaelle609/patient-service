<?php

namespace App\Models;

use App\Observers\PatientObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([PatientObserver::class])]
class Patient extends Model
{
    public $table = 'patients';
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    protected $fillable = [
        'slug',
        'first_name',
        'last_name',
        'phone',
        'address',
        'emergency_contact',
        'matrimonial_situation',
        'place_of_birth',
        'age'
    ];

    protected $casts = [
        'id' => 'integer',
        'slug' => 'string',
        'age' => 'integer',
        'first_name' => 'string',
        'last_name' => 'string',
        'phone' => 'string',
        'address' => 'string',
        'emergency_contact' => 'string',
        'matrimonial_situation' => 'string',
        'place_of_birth' => 'string'    
    ];

    public static array $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'phone' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'emergency_contact' => 'required|string|max:255',
        'matrimonial_situation' => 'required|string|max:255',
        'place_of_birth' => 'required|string|max:255',
        'age' => 'required|integer' 
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
