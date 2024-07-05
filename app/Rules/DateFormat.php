<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;

class DateFormat implements Rule
{
    public function passes($attribute, $value)
    {
        try {
            $date = Carbon::createFromFormat('d.m.Y', $value);
            return $date && $date->format('d.m.Y') === $value && $this->isAfterOrSameAsToday($date);
        } catch (\Exception $e) {
            return false;
        }
    }

    private function isAfterOrSameAsToday(Carbon $date)
    {
        return $date->greaterThanOrEqualTo(Carbon::today());
    }

    public function message()
    {
        return 'The :attribute must be a valid date in the format dd.mm.Y and not in the past.';
    }
}
