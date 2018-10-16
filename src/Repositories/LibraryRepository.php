<?php

namespace CeddyG\ClaraLibrary\Repositories;

use CeddyG\QueryBuilderRepository\QueryBuilderRepository;

class LibraryRepository extends QueryBuilderRepository
{
    protected $sTable = 'library';

    protected $sPrimaryKey = 'id_library';
    
    protected $sDateFormatToGet = 'd/m/Y';
    
    /**
     * Indicates if the query should be timestamped.
     *
     * @var bool
     */
    protected $bTimestamp = true;
    
    protected $aRelations = [
        'library_category'
    ];

    protected $aFillable = [
        'fk_library_category',
		'title_library',
		'url_library',
		'description_library'
    ];
    
   
    public function library_category()
    {
        return $this->belongsTo('CeddyG\ClaraLibrary\Repositories\LibraryCategoryRepository', 'fk_library_category');
    }


}
