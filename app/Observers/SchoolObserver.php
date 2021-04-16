<?php

namespace App\Observers;

use App\Common\CacheKey;
use App\Models\School;
use Illuminate\Support\Facades\Cache;

class SchoolObserver
{
    /**
     * Handle the school "created" event.
     *
     * @param  \App\School $school
     * @return void
     */
    public function created(School $school)
    {
        Cache::forget(CacheKey::SCHOOL_ACTIVE_LIST);
    }

    /**
     * Handle the school "updated" event.
     *
     * @param  \App\School $school
     * @return void
     */
    public function updated(School $school)
    {
        Cache::forget(CacheKey::SCHOOL_ACTIVE_LIST);
    }

    /**
     * Handle the school "deleted" event.
     *
     * @param  \App\School $school
     * @return void
     */
    public function deleted(School $school)
    {
        Cache::forget(CacheKey::SCHOOL_ACTIVE_LIST);
    }

    /**
     * Handle the school "restored" event.
     *
     * @param  \App\School $school
     * @return void
     */
    public function restored(School $school)
    {
        //
    }

    /**
     * Handle the school "force deleted" event.
     *
     * @param  \App\School $school
     * @return void
     */
    public function forceDeleted(School $school)
    {
        //
    }
}
