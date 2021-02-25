<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservacionRequest extends FormRequest
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
            'fecha' => 'required',
            'sede' => 'required',
            'servicio' => 'required',
            'vehiculo' => 'required',
            'placa' => 'required',
            'nombre' => 'required',
            'cedula' => 'required',
            'phone' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'fecha.required' => 'Campo requerido',
            'sede.required' => 'Campo requerido',
            'servicio.required' => 'Campo requerido',
            'vehiculo.required' => 'Campo requerido',
            'placa.required' => 'Campo requerido',
            'nombre.required' => 'Campo requerido',
            'cedula.required' => 'Campo requerido',
            'phone.required' => 'Campo requerido',
        ];
    }
}
