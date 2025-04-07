<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RepresentativeRequest extends FormRequest
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
            'image' => ['required'],
            'name' => ['required'],
            'area' => ['required'],
            'genre' => ['required'],
            'overview' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'image.required' => '画像を入力してください。',
            'name.required' => '名前を入力してください。',
            'area.required' => 'エリアを入力してください。',
            'genre.required' => 'ジャンルを入力してください。',
            'overview.required' => '概要を入力してください。',
        ];
    }
}
