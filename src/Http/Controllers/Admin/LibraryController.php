<?php

namespace CeddyG\ClaraLibrary\Http\Controllers\Admin;

use App\Http\Controllers\ContentManagerController;

use CeddyG\ClaraLibrary\Repositories\LibraryRepository;
use CeddyG\ClaraLibrary\Events\Library\BeforeStoreEvent;
use CeddyG\ClaraLibrary\Events\Library\BeforeUpdateEvent;
use CeddyG\ClaraLibrary\Events\Library\BeforeDestroyEvent;

class LibraryController extends ContentManagerController
{
    protected $sEventBeforeStore    = BeforeStoreEvent::class;
    protected $sEventBeforeUpdate   = BeforeUpdateEvent::class;
    protected $sEventBeforeDestroy  = BeforeDestroyEvent::class;

    public function __construct(LibraryRepository $oRepository)
    {
        $this->sPath            = 'clara-library::admin.library';
        $this->sPathRedirect    = 'admin/library';
        $this->sName            = __('clara-library::library.library');
        
        $this->oRepository  = $oRepository;
        $this->sRequest     = 'CeddyG\ClaraLibrary\Http\Requests\LibraryRequest';
    }
}
