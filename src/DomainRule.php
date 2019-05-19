<?php

namespace DomainRule;

use Illuminate\Contracts\Validation\Rule;

class DomainRule implements Rule
{
    private $factoryClosure;
    private $errorMessage;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(\Closure $factoryClosure, string $errorMessage = null)
    {
        $this->factoryClosure = $factoryClosure;
        $this->errorMessage = $errorMessage;
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
        try {
            ($this->factoryClosure)($value);
        } catch (\DomainException $e) {
            if (!$this->errorMessage) {
                $this->errorMessage = $attribute . $e->getMessage();
            }
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->errorMessage;
    }
}