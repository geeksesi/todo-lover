<?php

namespace Geeksesi\TodoLover\Observers;

use Geeksesi\TodoLover\Models\Label;

class LabelObserver
{
    public $afterCommit = true;
    /**
     * Handle the Label "created" event.
     *
     * @param  \Geeksesi\TodoLover\Models\Label $label
     * @return void
     */
    public function created(Label $label)
    {
    }

    /**
     * Handle the Label "updated" event.
     *
     * @param  \Geeksesi\TodoLover\Models\Label $label
     * @return void
     */
    public function updated(Label $label)
    {
        //
    }

    /**
     * Handle the Label "deleted" event.
     *
     * @param  \Geeksesi\TodoLover\Models\Label $label
     * @return void
     */
    public function deleted(Label $label)
    {
        //
    }

    /**
     * Handle the Label "restored" event.
     *
     * @param  \Geeksesi\TodoLover\Models\Label $label
     * @return void
     */
    public function restored(Label $label)
    {
        //
    }

    /**
     * Handle the Label "force deleted" event.
     *
     * @param  \Geeksesi\TodoLover\Models\Label $label
     * @return void
     */
    public function forceDeleted(Label $label)
    {
        //
    }
}
