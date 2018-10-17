<?php

namespace CeddyG\ClaraLibrary\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use CeddyG\ClaraLibrary\Repositories\LibraryCategoryRepository;

class LibraryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    
    public function all($keys = null)
    {
        $aAttribute = parent::all($keys);
        
        if ($this->hasFile('file'))
        {
            $oCategoryRepository = new LibraryCategoryRepository();
            $oCategory = $oCategoryRepository->find($aAttribute['fk_library_category'], ['slug_library_category']);
            
            $sName = $this->file('file')->getClientOriginalName();
            
            $aAttribute['url_library'] = 'storage/'.config('clara.library.folder').'/'.$oCategory->slug_library_category.'/'.$sName;
        }
        
        return $aAttribute;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method())
        {
            case 'POST':
            {
                return [
                    'id_library'            => 'numeric',
                    'fk_library_category'   => 'numeric',
                    'title_library'         => 'string|max:60',
                    'slug_library'          => 'string|max:60|unique:library',
                    'url_library'           => 'string|max:255|unique:library',
                    'file'                  => 'required|file',
                    'description_library'   => '',
                    'created_at'            => 'string',
                    'updated_at'            => 'string'
                ];
            }
            
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'id_library'            => 'numeric',
                    'fk_library_category'   => 'numeric',
                    'title_library'         => 'string|max:60',
                    'slug_library'         => 'string|max:60|unique:library,slug_library,'.$this->library.',id_library',
                    'url_library'           => 'string|max:255|unique:library,url_library,'.$this->library.',id_library',
                    'file'                  => 'file',
                    'description_library'   => '',
                    'created_at'            => 'string',
                    'updated_at'            => 'string'
                ];
            }
        }
    }
}

