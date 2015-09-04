<?php namespace Vdbf\Components\Cashweb\Elements;


class Field extends AbstractElement
{

    public function __construct($key, $value)
    {
        $this->setName('F' . $key);
        $this->setValue($value);
    }

}