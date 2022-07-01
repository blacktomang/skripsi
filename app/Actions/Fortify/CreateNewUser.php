<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Rules\Password;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    private $isAdmin  = false;

    function __construct()
    {
        if (Auth::check()) {
            if (Auth::user()->role == 1) $this->isAdmin = true;
        }
    }

    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'min:11', 'max:13'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => [
                (new Password)
                    ->length(6)
                    ->requireNumeric()
                    ->requireSpecialCharacter()
            ],
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone_number' => $input['phone_number'],
            'added_by' => $this->isAdmin ? Auth::id() : null,
            'role' => isset($input['role']) && $this->isAdmin ? $input['role'] : 2,
            'password' => Hash::make($input['password']),
        ]);
    }
}
