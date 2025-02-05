<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
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
            'email' => 'required|string',
            'password' => 'required|string',
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        $this->ensureIsNotRateLimited();


//        $organization = Organization::query()->where()

        $user = User::query()->with('organization')
            ->where('email', '=', $this->email)
            ->orWhere('login', '=', $this->email)
            ->first();

        if ($user) {
            $organization = $user->organization()->first();
            if (!is_null($organization)) {
                if (is_null($organization->date_end) || $organization->date_end > time()) {
                    if (!Auth::attempt(['email' => $user->email, 'password' => $this->password],
                        $this->boolean('remember'))) {
                        RateLimiter::hit($this->throttleKey());
                        throw ValidationException::withMessages([
                            'email' => __('auth.failed'),
                        ]);
                    }
                } else {
                    throw ValidationException::withMessages([
                        'email' => __('auth.expired'),
                    ]);
                }
            } else {
                throw ValidationException::withMessages([
                    'email' => __('auth.expired'),
                ]);
            }
        } else {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower($this->input('email')) . '|' . $this->ip();
    }
}
