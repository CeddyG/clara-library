<?php

namespace CeddyG\ClaraLibrary;

use CeddyG\ClaraLibrary\Repositories\LibraryRepository;
use CeddyG\ClaraLibrary\Repositories\LibraryCategoryRepository;
/**
 * Description of Library
 *
 * @author Cedric
 */
class Library
{
    private $oLibraryRepository;
    private $oLibraryCategoryRepository;
    
    private $aCacheUrl = [];

    public function __construct(LibraryRepository $oLibraryRepository, LibraryCategoryRepository $oLibraryCategoryRepository)
    {
        $this->oLibraryRepository           = $oLibraryRepository;
        $this->oLibraryCategoryRepository   = $oLibraryCategoryRepository;
    }
    
    public function getUrl($mIdOrSlug)
    {
        if (!isset($this->aCacheUrl[$mIdOrSlug]))
        {
            $this->aCacheUrl[$mIdOrSlug] = $this->oLibraryRepository->getFullUrl($mIdOrSlug);
        }
        
        return $this->aCacheUrl[$mIdOrSlug];
    }
}
