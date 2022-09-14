<?php

namespace Sdkconsultoria\WhatsappCloudApi\Models\Template\Button;

use ErrorException;
use Sdkconsultoria\WhatsappCloudApi\Models\Template\MetaElement;

class ButtonGroup implements MetaElement
{
    protected $type = "BUTTONS";
    protected $buttons = [];

    public function addButton(Button $button)
    {
        switch ($button->type) {
            case 'PHONE_NUMBER';
                $this->validateIfCanAddNewPhoneButtonOrThrowExeption();
                break;

            case 'URL';
                $this->validateIfCanAddNewPhoneButtonOrThrowExeption();
                break;

            case 'QUICK_REPLY';
                $this->validateIfCanAddNewTextButtonOrThrowExeption();
                break;
        }

        $this->buttons[] = $button;
    }

    public function validate(): void
    {
        $this->validateIfButtonsAreNoEmpty();
    }

    protected function validateIfButtonsAreNoEmpty()
    {
        if(count($this->buttons) == 0) {
            throw new ErrorException("Debes agregar almenos un boton");
        }
    }

    protected function validateIfCanAddNewTextButtonOrThrowExeption()
    {
        if ($this->searchButtonType('URL')) {
            throw new ErrorException("you can't add QUICK_REPLY button with URL Button");
        }

        if ($this->searchButtonType('PHONE_NUMBER')) {
            throw new ErrorException("you can't add QUICK_REPLY button with PHONE_NUMBER Button");
        }

        if (count($this->buttons) > 2) {
            throw new ErrorException("you can't add more than 3 QUICK_REPLY button");
        }
    }

    protected function validateIfCanAddNewUrlButtonOrThrowExeption()
    {
        if ($this->searchButtonType('URL')) {
            throw new ErrorException("you can't add more than one add button");
        }

        if ($this->searchButtonType('QUICK_REPLY')) {
            throw new ErrorException("you can't add Url button with QUICK_REPLY Button");
        }
    }
    protected function validateIfCanAddNewPhoneButtonOrThrowExeption()
    {
        if ($this->searchButtonType('PHONE_NUMBER')) {
            throw new ErrorException("you can't add more than one PHONE_NUMBER button");
        }

        if ($this->searchButtonType('QUICK_REPLY')) {
            throw new ErrorException("you can't add phone button with QUICK_REPLY Button");
        }
    }

    protected function searchButtonType(string $type): bool
    {
        foreach ($this->getButtonsAsArray() as $button) {
            if ($button->type = $type) {
                return true;
            }
        }

        return false;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'buttons' => $this->getButtonsAsArray(),
        ];
    }

    protected function getButtonsAsArray()
    {
        return array_map(fn($item) => $item->toArray(), $this->buttons);
    }
}
