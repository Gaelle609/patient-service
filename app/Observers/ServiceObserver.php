<?php

namespace App\Observers;

use App\Models\Service;

class ServiceObserver
{
    public function creating(Service $service)
    {
        $service->slug = makeSlug($service);
    }

    public function created(Service $service): void
    {
        \App\Events\ServiceCreatedEvent::dispatch($service);
    }

    /**
     * Handle the Service "updated" event.
     */
    public function updated(Service $service): void
    {
        \App\Events\ServiceUpdatedEvent::dispatch($service);
    }
    /**
     * Handle the Service "deleted" event.
     */
    public function deleted(Service $service): void
    {
        \App\Events\ServiceDeletedEvent::dispatch($service);
    }

    /**
     * Handle the Service "restored" event.
     */
    public function restored(Service $service): void
    {
        //
    }

    /**
     * Handle the Service "force deleted" event.
     */
    public function forceDeleted(Service $service): void
    {
        //
    }
}
