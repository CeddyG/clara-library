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
		'slug_library',
		'url_library',
		'description_library'
    ];
    
        /**
     * List of the customs attributes.
     * 
     * @var array
     */
    protected $aCustomAttribute = [
        'full_url' => [
            'url_library'
        ]
    ];


    public function library_category()
    {
        return $this->belongsTo('CeddyG\ClaraLibrary\Repositories\LibraryCategoryRepository', 'fk_library_category');
    }
    
    public function getFullUrlAttribute($oItem)
    {
        return url('/').'/'.$oItem->url_library;
    }
    
    public function getFullUrl($mIdOrSlug)
    {
        if (is_int($mIdOrSlug))
        {
            $oLibrary = $this->find($mIdOrSlug, ['url_library']);
            
            if ($oLibrary !== null)
            {
                return url('/').'/'.$oLibrary->url_library;
            }
            else
            {
                return '';
            }
        }
        else
        {
            $oLibrary = $this
                ->findByField('slug_library', $mIdOrSlug, ['url_library']);
            
            if ($oLibrary !== null)
            {
                return url('/').'/'.$oLibrary->first()->url_library;
            }
            else
            {
                return '';
            }
        }
    }
}
