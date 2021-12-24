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
        $rule = ["password" => ['string', 'required', "max:255"]];
        if (strpos($this->login, '@')) {
            $rule['login'] = ['string', 'required', "email:rfc,dns", "max:255"];
        } else
            $rule['login'] = ['string', 'required', 'alpha_num', 'max:255'];

        return $rule;
    }

    /**
     * Получить пользовательские имена атрибутов для формирования ошибок валидатора.
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
