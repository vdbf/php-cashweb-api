<?php namespace Vdbf\Components\Cashweb\Elements;


class Record extends AbstractElement
{

    public function __construct($key, $children = [])
    {
        $this->setName('R' . $key);
        $this->setChildren($children);
    }

}