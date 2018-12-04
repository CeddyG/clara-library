<?php

namespace CeddyG\ClaraLibrary\Http\Controllers\Admin;

use App\Http\Controllers\ContentManagerController;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
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
        $this->sTypeRoute   = app($this->sRequest)->is('api/*') ? 'api' : 'web';
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAjax(Request $oRequest)
    {
        $aInputs = $oRequest->all();
        $this->oRepository->setReturnCollection(false);
        
        $oItems = $this->oRepository->findByField(
            'fk_library_category', 
            $aInputs['fk_library_category'],
            [
                'title_library',
                'full_url',
            ]
        );
        
        return new JsonResponse($oItems);
    }
    
    public function store()
    {
        $oResponse = parent::store();
        
        if ($oResponse instanceof JsonResponse)
        {
            $oLibrary = $this->oRepository->find($oResponse->original['id']);
            
            return response()->json([
                'initialPreview' => [
                    [asset($oLibrary->url_library)]
                ],
                'initialPreviewConfig' => [
                    [
                        'key'           => $oResponse->original['id'],
                        'caption'       => $oLibrary->title_library, 
                        'downloadUrl'   => asset($oLibrary->url_library),
                        'url'           => route('api.admin.library.destroy', $oResponse->original['id']),
                        'filename'      => asset($oLibrary->url_library)
                    ]
                ]
            ], 200);
        }
        else
        {
            return $oResponse;
        }
    }
}
