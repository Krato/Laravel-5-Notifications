<?php

namespace Infinety\Notifications\Requests;

use App\Http\Requests\Request;

class NotificationRequest extends Request
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
            'model'   => 'required',
            'ntype'   => 'required',
            'subject' => 'required',
            'message' => 'required',
        ];
    }
}
