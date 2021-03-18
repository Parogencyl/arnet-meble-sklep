<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class OrderPostRequest extends FormRequest
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
        if(Auth::user()){
            return [
                  'email' => 'required|email|max:255',
                  'name' => 'required|alpha|max:30',
                  'surname' => 'required|alpha|max:50',
                  'street' => 'required|string|max:50',
                  'numberOfFlat' => 'required|max:12',
                  'numberOfFlat2' => 'nullable|max:12',
                  'city' => 'required|string|max:50',
                  'zip' => 'required|max:6|min:6',
                  'phone' => 'required|max:15',
                  'regulamin' => 'accepted',
                ];
        }
        return [
              'email' => 'required|email|max:255',
              'name' => 'required|alpha|max:30',
              'surname' => 'required|alpha|max:50',
              'street' => 'required|string|max:50',
              'numberOfFlat' => 'required|max:12',
              'city' => 'required|string|max:50',
              'zip' => 'required|max:6|min:6',
              'phone' => 'required|max:15',
              'password' => 'nullable|min:8|max:30|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/',
              'regulamin' => 'accepted',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'Należy wypełnić podane pole.',
            'email.email' => 'Podany adres nie jest poprawnym adresem email.',
            'name.required' => 'Należy wypełnić podane pole.',
            'name.alpha' => 'Imie nie może składać się z cyfr.',
            'name.max' => 'Maksymalna liczba znaków wynosi 30.',
            'surname.required' => 'Należy wypełnić podane pole.',
            'surname.alpha' => 'Nazwisko nie może składać się z cyfr.',
            'surname.max' => 'Maksymalna liczba znaków wynosi 50.',
            'street.required' => 'Należy wypełnić podane pole.',
            'street.max' => 'Zbyt duża liczba znaków.',
            'street2.max' => 'Zbyt duża liczba znaków.',
            'numberOfFlat.required' => 'Należy wypełnić podane pole.',
            'numberOfFlat.max' => 'Zbyt duża liczba znaków.',
            'numberOfFlat2.max' => 'Zbyt duża liczba znaków.',
            'city.required' => 'Należy wypełnić podane pole.',
            'city.max' => 'Zbyt duża liczba znaków.',
            'city2.max' => 'Zbyt duża liczba znaków.',
            'zip.required' => 'Należy wypełnić podane pole.',
            'zip.max' => 'Maksymalna liczba znaków wynosi 6.',
            'zip.min' => 'Minimalna liczba znaków wynosi 6.',
            'zip2.max' => 'Maksymalna liczba znaków wynosi 6.',
            'zip2.min' => 'Minimalna liczba znaków wynosi 6.',
            'phone.required' => 'Należy wypełnić podane pole.',
            'password.required' => 'Należy wypełnić podane pole w celu utworzenia konta.',
            'password.min' => 'Hasło powinno składać się z co najmniej 8 znaków.',
            'password.max' => 'Hasło powinno składać się z maksymalnie 30 znaków.',
            'password.regex' => 'Hasło powinno zawieć małą, dużą literę oraz cyfrę.',
            'ragulamin.accepted' => 'W celu kontynuacji należy zaakceptować regulamin seriwsu.',
        ];
    }
}
