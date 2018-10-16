<?php

namespace CeddyG\ClaraLibrary\Listeners;

class LibrarySubscriber
{
    public function upload($oEvent)
    {
        
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $oEvent
     */
    public function subscribe($oEvent)
    {
        $oEvent->listen(
            'CeddyG\ClaraLibrary\Events\Library\BeforeStoreEvent',
            'CeddyG\ClaraLibrary\Listeners\LibrarySubscriber@upload'
        );

        $oEvent->listen(
            'CeddyG\ClaraLibrary\Events\Library\BeforeUpdateEvent',
            'CeddyG\ClaraLibrary\Listeners\LibrarySubscriber@upload'
        );

        $oEvent->listen(
            'CeddyG\ClaraLibrary\Events\Library\BeforeDestroyEvent',
            'CeddyG\ClaraLibrary\Listeners\LibrarySubscriber@delete'
        );
    }

}
