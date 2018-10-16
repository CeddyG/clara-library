<?php

namespace CeddyG\ClaraLibrary\Repositories;

use CeddyG\QueryBuilderRepository\QueryBuilderRepository;

class LibraryCategoryRepository extends QueryBuilderRepository
{
    protected $sTable = 'library_category';

    protected $sPrimaryKey = 'id_library_category';
    
    protected $sDateFormatToGet = 'd/m/Y';
    
    /**
     * Indicates if the query should be timestamped.
     *
     * @var bool
     */
    protected $bTimestamp = true;
    
    protected $aRelations = [
        'library'
    ];
    

    protected $aFillable = [
        'name_library_category',
		'slug_library_category'
    ];
    
   
    public function library()
    {
        return $this->hasMany('CeddyG\ClaraLibrary\Repositories\LibraryRepository', 'fk_library_category');
    }


}
