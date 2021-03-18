<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductAddRequest extends FormRequest
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
        return [
              'rodzaj' => 'nullable',
              'kategoria' => 'nullable',
              'nazwa' => 'required|unique:products|max:255',
              'cena' => 'required|numeric',
              'nowa_cena' => 'nullable|numeric',
              'koszt_wysylki' => 'required|numeric',
              'ilosc_w_paczce' => 'required|integer',
              'ilosc_dostepnych' => 'required|integer',
              'zdjecie1' => 'required',
              'szerokosc' => 'nullable|numeric',
              'wysykosc' => 'nullable|numeric',
              'glebokosc' => 'nullable|numeric',
              'waga' => 'nullable|numeric',
              'opis' => 'required',
              'kolor' => 'nullable|string',
              'material' => 'nullable|string',
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
            'nazwa.required' => 'Należy wypełnić podane pole.',
            'nazwa.unique' => 'Istnieje przedmiot o takiej nazwie.',
            'nazwa.max' => 'Maksymalna liczba znaków wynosi 255.',
            'cena.required' => 'Należy wypełnić podane pole.',
            'cena.numeric' => 'Niepoprawna forma zapisu. Cena powinna zawierać tylko znaki numeryczne oddzielone znakiem kropki ( . ).',
            'nowa_cena.numeric' => 'Niepoprawna forma zapisu. Cena powinna zawierać tylko znaki numeryczne oddzielone znakiem kropki ( . ).',
            'koszt_wysylki.required' => 'Należy wypełnić podane pole.',
            'koszt_wysylki.numeric' => 'Niepoprawna forma zapisu. Koszt wysyłki powinien zawierać tylko znaki numeryczne oddzielone znakiem kropki ( . ).',
            'ilosc_w_paczce.required' => 'Należy wypełnić podane pole.',
            'ilosc_w_paczce.integer' => 'Niepoprawna forma zapisu. Wartość powinna zawierać tylko znaki numeryczne.',
            'ilosc_dostepnych.required' => 'Należy wypełnić podane pole.',
            'ilosc_dostepnych.integer' => 'Niepoprawna forma zapisu. Wartość powinna zawierać tylko znaki numeryczne.',
            'zdjecie1.required' => 'Należy dodać plik graficzny.',
            'szerokosc.numeric' => 'Niepoprawna forma zapisu. Wartość powinna zawierać tylko znaki numeryczne.',
            'wysykosc.numeric' => 'Niepoprawna forma zapisu. Wartość powinna zawierać tylko znaki numeryczne.',
            'glebokosc.numeric' => 'Niepoprawna forma zapisu. Wartość powinna zawierać tylko znaki numeryczne.',
            'waga.numeric' => 'Niepoprawna forma zapisu. Wartość powinna zawierać tylko znaki numeryczne.',
            'opis.required' => 'Należy wypełnić podane pole.',
        ];
    }
}
