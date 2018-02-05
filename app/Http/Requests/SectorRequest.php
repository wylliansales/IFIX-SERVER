<?php

namespace App\Http\Requests;

use App\Models\Attendant;
use Illuminate\Foundation\Http\FormRequest;


class SectorRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $attendant = Attendant::where('user_id', 1)->first();

        if(!empty($attendant) && $attendant->coordinator){
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

        ];
    }
}
