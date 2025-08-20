<?php

namespace Tests\Feature;

use App\Events\PatientCreatedEvent;
use App\Events\PatientDeletedEvent;
use App\Events\PatientUpdatedEvent;
use App\Models\Patient;
use App\Observers\PatientObserver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

uses(RefreshDatabase::class);
uses(\Tests\TestCase::class); 

beforeEach(function () {
    Patient::observe(PatientObserver::class);
});


it('does not register a patient without required fields', function () {

    $token = getFakeJwtToken();
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->postJson('/api/patients', []);
    $response->assertStatus(422);
});

it('can create a patient', function () {
    Event::fake([PatientCreatedEvent::class]); 
    $token = getFakeJwtToken();
    $attributes = Patient::factory()->raw(); 
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->postJson('/api/patients', $attributes);
    $response->assertStatus(200);

    Event::assertDispatched(PatientCreatedEvent::class);
});


it('can update a patient', function () {
    Event::fake([PatientUpdatedEvent::class]);
    $token = getFakeJwtToken();
    $patient= Patient::factory()->create();

    $attributes = Patient::factory()->raw(); 
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->putJson("/api/patients/{$patient->id}", $attributes);

    $response->assertStatus(200);

   Event::assertDispatched(PatientUpdatedEvent::class);
});

it('can get a patients', function () {
    $patient= Patient::factory()->create();
    $token = getFakeJwtToken();

     $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->getJson("/api/patients");
    $response->assertStatus(200);
    
});

it('can get a patient', function () {
    $patient= Patient::factory()->create();
    $token = getFakeJwtToken();

    $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson("/api/patients/{$patient->id}");
        $response->assertStatus(200);
    });

it('can delete article', function () {
    Event::fake([PatientDeletedEvent::class]);
    $token = getFakeJwtToken();
    $patient= Patient::factory()->create();

     $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->deleteJson("/api/patients/{$patient->id}");
    $response->assertStatus(200);
    Event::assertDispatched(PatientDeletedEvent::class);
});


