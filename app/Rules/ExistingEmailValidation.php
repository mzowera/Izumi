<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use DB;

class ExistingEmailValidation implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($current_email, $table)
    {
        $this->current_email = $current_email;
        $this->table = $table;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $value = trim($value);
        $is_current_email = strtolower($value) == strtolower($this->current_email);
        $is_unique = DB::table($this->table)->where('email', 'like', $value)->first() === null;
        $is_empty = empty($value);

        return ( $is_current_email || $is_unique ) && !$is_empty && strlen($value) <= 255;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The email has already been taken.';
    }
}
