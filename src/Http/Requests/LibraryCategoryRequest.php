<?php

namespace CeddyG\ClaraLibrary\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LibraryCategoryRequest extends FormRequest
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
        
        if (isset($aAttribute['slug_library_category']))
        {
            $aAttribute['slug_library_category'] = str_slug($aAttribute['slug_library_category']);
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
                    'id_library_category'   => 'numeric',
                    'name_library_category' => 'string|max:45',
                    'slug_library_category' => 'string|max:45|unique:library_category',
                    'created_at'            => 'string',
                    'updated_at'            => 'string'
                ];
            }
            
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'id_library_category'   => 'numeric',
                    'name_library_category' => 'string|max:45',
                    'slug_library_category' => 'string|max:45|unique:library_category,slug_library_category,'.$this->library_category.',id_library_category',
                    'created_at'            => 'string',
                    'updated_at'            => 'string'
                ];
            }
        }
    }
}

