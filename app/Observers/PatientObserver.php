<?php

namespace App\Observers;

use App\Models\Patient;

class PatientObserver
{
    public function creating(Patient $patient)
    {
        $patient->slug = makeSlug($patient);
    }
    public function created(Patient $patient): void
    {
        \App\Events\PatientCreatedEvent::dispatch($patient);
    }

    /**
     * Handle the Patient "updated" event.
     */
    public function updated(Patient $patient): void
    {
        \App\Events\PatientUpdatedEvent::dispatch($patient);
    }

    /**
     * Handle the Patient "deleted" event.
     */
    public function deleted(Patient $patient): void
    {
        \App\Events\PatientDeletedEvent::dispatch($patient);
    }

    /**
     * Handle the Patient "restored" event.
     */
    public function restored(Patient $patient): void
    {
        //
    }

    /**
     * Handle the Patient "force deleted" event.
     */
    public function forceDeleted(Patient $patient): void
    {
        //
    }
}
