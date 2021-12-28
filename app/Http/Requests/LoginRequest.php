<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = ["password" => ['string', 'required', "max:255"]];
        if (strpos($this->login, '@')) {
            $rules['login'] = ['string', 'required', "email:rfc,dns", "max:255"];
        } else
            $rules['login'] = ['string', 'required', 'alpha_num', 'max:255'];

        return $rules;
    }

    /**
     * Get custom attribute names for generating validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        if (strpos($this->login, '@')) {
            return [
                'login' => 'email address',
            ];
        } else {
            return [
                'login' => 'user name',
            ];
        }
    }
}
