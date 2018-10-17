<?php

namespace CeddyG\ClaraLibrary\Listeners;

class LibrarySubscriber
{
    public function upload($oEvent)
    {
        if (isset($oEvent->aInputs['file']))
        {
            $oEvent->aInputs['file']->storeAs(
                $oEvent->aInputs['url_library'], 
                $oEvent->aInputs['file']->getClientOriginalName()
            );
        }
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
