<?php

namespace Sdkconsultoria\WhatsappCloudApi\Models\Template\Validation;

use ErrorException;

Trait ValidateIfNeedExample {

    protected $number_of_variables = 0;

    protected function validateIfNeedExample(): void
    {
        if ($this->countVariables() == 0) {
            return;
        }

        $this->validateExample();
    }

    protected function countVariables(): int
    {
        $this->number_of_variables = preg_match_all('/\{\{\d\}\}/i', $this->text);

        return $this->number_of_variables;
    }

    protected function validateExample(): void
    {
        if (!$this->example || count($this->example) != $this->number_of_variables) {
            throw new ErrorException("El ejemplo no es valido");
        }
    }
}