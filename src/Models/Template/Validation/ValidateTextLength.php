<?php

namespace Sdkconsultoria\WhatsappCloudApi\Models\Template\Validation;

use ErrorException;

Trait ValidateTextLength {

    protected function validateTextMinLength($text, $min_length): void
    {
        if (strlen($text) < 2) {
            throw new ErrorException("El texto debe contener almenos {$min_length} caracteres");
        }
    }

    protected function validateTextMaxLength($text, $max_length): void
    {
        if (strlen($text) > $max_length) {
            throw new ErrorException("El tamaño maximo del texto es de {$max_length} caracteres");
        }
    }
}