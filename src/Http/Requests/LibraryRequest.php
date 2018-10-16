<?php

namespace CeddyG\ClaraLibrary\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        
        if (isset($aAttribute['url_library']))
        {
            $aAttribute['url_library'] = str_slug($aAttribute['url_library']);
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
                    'url_library'           => 'string|max:255|unique:library',
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
                    'url_library'           => 'string|max:255|unique:library,url_library,'.$this->library.',id_library',
                    'description_library'   => '',
                    'created_at'            => 'string',
                    'updated_at'            => 'string'
                ];
            }
        }
    }
}

