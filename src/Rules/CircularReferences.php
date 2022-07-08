<?php

namespace Maslennikov\Authorizator\Rules;

use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;
use Maslennikov\Authorizator\Facade\Authorizator;

class CircularReferences implements Rule, DataAwareRule
{

    /**
     * The data under validation.
     *
     * @var array
     */
    protected array $data;

    /**
     * @param array $data
     * @return CircularReferences
     */
    public function setData($data): CircularReferences
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $circularReferences = Authorizator::checkCircularReferences($this->data['slug'], $value);
        return empty($circularReferences);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute contain circular references';
    }
}
