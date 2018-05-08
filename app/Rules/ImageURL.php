<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ImageURL implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $splitted = explode(".", $value);
        $ext = end($splitted);
        $headers = get_headers($value);
        $containsImage = in_array('Content-Type: image/jpeg', $headers) || in_array('Content-Type: image/png', $headers);
        return ($ext === 'png' || $ext === 'jpg' || $ext === "jpeg") && $containsImage;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This URL doesn\'t contain image.';
    }
}
