<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class UpdateProfileRequest extends FormRequest
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

    // protected function prepareForValidation()
    // {
    //     // $path = $this["avatar"]->store('avatars');
    //     // Storage::delete(auth()->user()->profile->avatar_path);
    //     // $this["avatar_path"] = $path;
    //     // $this["avatar"] = null;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['string', 'min:1', 'max:25', 'alpha'],
            'last_name' => ['nullable', 'string', 'max:25', 'alpha'],
            "avatar" => ["nullable", "image", 'mimes:jpg,png'],
            "background" => ["image", 'mimes:jpg,png'],
            "lat" => ["nullable", 'numeric'],
            "lng" => ["nullable", 'numeric'],
        ];
    }
}
