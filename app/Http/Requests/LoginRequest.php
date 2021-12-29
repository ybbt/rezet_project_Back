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

    protected function prepareForValidation()
    {
        if (strpos($this->login, '@')) {
            $this['email'] = $this->login;
        } else {
            $this['name'] = $this->login;
        }
        $this["login"] = null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = ["password" => ['string', 'required', "max:255"]];
        if ($this->email) {
            $rules['email'] = ['string', 'required', "email:rfc,dns", "max:255"];
        } else
            $rules['name'] = ['string', 'required', 'alpha_num', 'max:255'];

        return $rules;
    }
}
