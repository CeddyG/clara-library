<?php

namespace CeddyG\ClaraLibrary\Http\Controllers\Admin;

use CeddyG\Clara\Http\Controllers\ContentManagerController;

use CeddyG\ClaraLibrary\Repositories\LibraryCategoryRepository;

class LibraryCategoryController extends ContentManagerController
{
    public function __construct(LibraryCategoryRepository $oRepository)
    {
        $this->sPath            = 'clara-library::admin.library-category';
        $this->sPathRedirect    = 'admin/library-category';
        $this->sName            = __('clara-library::library-category.library_category');
        
        $this->oRepository  = $oRepository;
        $this->sRequest     = 'CeddyG\ClaraLibrary\Http\Requests\LibraryCategoryRequest';
    }
}
