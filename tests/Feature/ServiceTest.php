<?php

namespace Tests\Feature;

use App\Events\ServiceCreatedEvent;
use App\Events\ServiceDeletedEvent;
use App\Events\ServiceUpdatedEvent;
use App\Models\Service;
use App\Observers\ServiceObserver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

uses(RefreshDatabase::class);
uses(\Tests\TestCase::class); 

beforeEach(function () {
    Service::observe(ServiceObserver::class);
});


it('does not register a service without required fields', function () {

    $token = getFakeJwtToken();
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->postJson('/api/services', []);
    $response->assertStatus(422);
});

it('can create a service', function () {
    Event::fake([ServiceCreatedEvent::class]); 
    $token = getFakeJwtToken();
    $attributes = Service::factory()->raw(); 
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->postJson('/api/services', $attributes);
    $response->assertStatus(200);

    Event::assertDispatched(ServiceCreatedEvent::class);
});


it('can update a service', function () {
    Event::fake([ServiceUpdatedEvent::class]);
    $token = getFakeJwtToken();
    $service= Service::factory()->create();

    $attributes = Service::factory()->raw(); 
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->putJson("/api/services/{$service->id}", $attributes);

    $response->assertStatus(200);

   Event::assertDispatched(ServiceUpdatedEvent::class);
});

it('can get a services', function () {
    $service= Service::factory()->create();
    $token = getFakeJwtToken();

     $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->getJson("/api/services");
    $response->assertStatus(200);
    
});

it('can get a service', function () {
    $service= Service::factory()->create();
    $token = getFakeJwtToken();

    $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson("/api/services/{$service->id}");
        $response->assertStatus(200);
    });

it('can delete article', function () {
    Event::fake([ServiceDeletedEvent::class]);
    $token = getFakeJwtToken();
    $service= Service::factory()->create();

     $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->deleteJson("/api/services/{$service->id}");
    $response->assertStatus(200);
    Event::assertDispatched(ServiceDeletedEvent::class);
});


