<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class FamilyMembersRequest extends Request
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
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'nickname' => 'string|required|unique:family_members',
            'lastname' => 'required|string',
            'phone' => 'required',
            'email' => 'required|email|max:255|unique:users',
            'address_1' => 'required',
            'city' => 'required|string',
            'zip' => 'required',
            'social_media' => 'required',
            'birthday' => 'required'
        ];
    }
}
