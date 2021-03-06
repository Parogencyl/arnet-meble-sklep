<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class OrderFakturaPostRequest extends FormRequest
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
                  'street2' => 'required|string|max:50',
                  'numberOfFlat' => 'required|max:12',
                  'numberOfFlat2' => 'required|max:12',
                  'city' => 'required|string|max:50',
                  'city2' => 'required|string|max:50',
                  'zip' => 'required|max:6|min:6',
                  'zip2' => 'required|max:6|min:6',
                  'phone' => 'required|max:15',
                  'company' => 'required|max:255',
                  'nip' => 'required|max:15',
                  'regulamin' => 'accepted',
                ];
        }
        return [
              'email' => 'required|email|max:255',
              'name' => 'required|alpha|max:30',
              'surname' => 'required|alpha|max:50',
              'street' => 'required|string|max:50',
              'street2' => 'required|string|max:50',
              'numberOfFlat' => 'required|max:12',
              'numberOfFlat2' => 'required|max:12',
              'city' => 'required|string|max:50',
              'city2' => 'required|string|max:50',
              'zip' => 'required|max:6|min:6',
              'zip2' => 'required|max:6|min:6',
              'phone' => 'required|max:15',
              'company' => 'required|max:255',
                'nip' => 'required|max:15',
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
            'email.required' => 'Nale??y wype??ni?? podane pole.',
            'email.email' => 'Podany adres nie jest poprawnym adresem email.',
            'name.required' => 'Nale??y wype??ni?? podane pole.',
            'name.alpha' => 'Imie nie mo??e sk??ada?? si?? z cyfr.',
            'name.max' => 'Maksymalna liczba znak??w wynosi 30.',
            'surname.required' => 'Nale??y wype??ni?? podane pole.',
            'surname.alpha' => 'Nazwisko nie mo??e sk??ada?? si?? z cyfr.',
            'surname.max' => 'Maksymalna liczba znak??w wynosi 50.',
            'street.required' => 'Nale??y wype??ni?? podane pole.',
            'street.max' => 'Zbyt du??a liczba znak??w.',
            'street2.required' => 'Nale??y wype??ni?? podane pole.',
            'street2.max' => 'Zbyt du??a liczba znak??w.',
            'numberOfFlat.required' => 'Nale??y wype??ni?? podane pole.',
            'numberOfFlat.max' => 'Zbyt du??a liczba znak??w.',
            'numberOfFlat2.required' => 'Nale??y wype??ni?? podane pole.',
            'numberOfFlat2.max' => 'Zbyt du??a liczba znak??w.',
            'city.required' => 'Nale??y wype??ni?? podane pole.',
            'city.max' => 'Zbyt du??a liczba znak??w.',
            'city2.required' => 'Nale??y wype??ni?? podane pole.',
            'city2.max' => 'Zbyt du??a liczba znak??w.',
            'zip.required' => 'Nale??y wype??ni?? podane pole.',
            'zip.max' => 'Maksymalna liczba znak??w wynosi 6.',
            'zip.min' => 'Minimalna liczba znak??w wynosi 6.',
            'zip2.required' => 'Nale??y wype??ni?? podane pole.',
            'zip2.max' => 'Maksymalna liczba znak??w wynosi 6.',
            'zip2.min' => 'Minimalna liczba znak??w wynosi 6.',
            'phone.required' => 'Nale??y wype??ni?? podane pole.',
            'company.required' => 'Nale??y wype??ni?? podane pole.',
            'company.max' => 'Zbyt du??a liczba znak??w',
            'nip.required' => 'Nale??y wype??ni?? podane pole.',
            'nip.max' => 'Maksymalna liczba znak??w wynosi 15.',
            'password.min' => 'Has??o powinno sk??ada?? si?? z co najmniej 8 znak??w.',
            'password.max' => 'Has??o powinno sk??ada?? si?? z maksymalnie 30 znak??w.',
            'password.regex' => 'Has??o powinno zawie?? ma????, du???? liter?? oraz cyfr??.',
            'ragulamin.accepted' => 'W celu kontynuacji nale??y zaakceptowa?? regulamin seriwsu.',
        ];
    }
}
