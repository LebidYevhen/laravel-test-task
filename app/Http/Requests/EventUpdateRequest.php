<?php

namespace App\Http\Requests;

use App\Models\Event;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EventUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'event_date' => [
                'required',
                'date',
            ],
            'venue_id' => [
                'required',
                'exists:venue,id',
            ],
        ];

        $event = $this->route('event');
        if (!$event || !$event->poster) {
            $rules['poster'] = ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'];
        } else {
            $rules['poster'] = ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'];
        }

        return $rules;
    }
}
