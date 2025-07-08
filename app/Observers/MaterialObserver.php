<?php

namespace App\Observers;

use App\Models\Material;
use Illuminate\Support\Facades\Storage;

class MaterialObserver
{
    /**
     * Handle the Material "creating" event.
     */
    public function creating(Material $material): void
    {
        $material->source = $material->source->store('materials');
    }

    /**
     * Handle the Material "updating" event.
     */
    public function updating(Material $material): void
    {
        if ($material->source) {
            Storage::delete($material->getOriginal('source'));
            $material->source = $material->source->store('materials');
        } else {
            $material->source = $material->getOriginal('source');
        }
    }

    /**
     * Handle the Material "deleting" event.
     */
    public function deleting(Material $material): void
    {
        Storage::delete($material->source);
    }

    /**
     * Handle the Material "restored" event.
     */
    public function restored(Material $material): void
    {
        //
    }

    /**
     * Handle the Material "force deleted" event.
     */
    public function forceDeleted(Material $material): void
    {
        //
    }
}
