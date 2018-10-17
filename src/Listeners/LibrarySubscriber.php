<?php

namespace CeddyG\ClaraLibrary\Listeners;

use CeddyG\ClaraLibrary\Repositories\LibraryCategoryRepository;

class LibrarySubscriber
{
    public function upload($oEvent)
    {
        if (isset($oEvent->aInputs['file']))
        {
            $oCategoryRepository = new LibraryCategoryRepository();
            $oCategory = $oCategoryRepository->find($oEvent->aInputs['fk_library_category'], ['slug_library_category']);
            
            $oEvent->aInputs['file']->storeAs(
                'public/'.config('clara.library.folder').'/'.$oCategory->slug_library_category, 
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
