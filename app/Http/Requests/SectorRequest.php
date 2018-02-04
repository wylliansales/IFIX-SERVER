<?php

namespace App\Http\Requests;

use App\Models\Attendant;
use App\Repositories\AttendantRepository;
use Illuminate\Foundation\Http\FormRequest;
use Laravel\Passport\Token;

class SectorRequest extends FormRequest
{



    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $attendant = Attendant::find(Token::all('user_id'));
        dd(Token::all(['user_id']));

        if($attendant->coordinator){
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
