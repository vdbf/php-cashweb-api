<?php namespace Vdbf\Components\Cashweb\Records;

use Vdbf\Components\Cashweb\Elements\AbstractElement;
use Vdbf\Components\Cashweb\Elements\Field;
use Vdbf\Components\Cashweb\Elements\Record;

/**
 * Class AbstractRecord
 *
 * @package Vdbf\Components\Cashweb\Records
 */
class AbstractRecord
{
    /**
     * @var int
     */
    protected static $recordIdentifier;

    /**
     * @var array
     */
    protected static $requiredFields = [];

    /**
     * @var array
     */
    protected static $safeStrFields = [];

    /**
     * @author Eelke van den Bos <eelkevdbos@gmail.com>
     * @return array
     */
    public static function getRequiredFields()
    {
        return static::$requiredFields;
    }

    /**
     * @author Eelke van den Bos <eelkevdbos@gmail.com>
     * @return int
     */
    public static function getRecordIdentifier()
    {
        return static::$recordIdentifier;
    }

    /**
     * @param $data
     * @author Eelke van den Bos <eelkevdbos@gmail.com>
     * @return Record
     */
    public static function fromArray($data)
    {
        $children = [];

        foreach ($data as $key => $value) {

            if (defined('static::' . $key)) {

                $children[] = new Field(
                    constant("static::{$key}"),
                    in_array($key, static::$safeStrFields) ? AbstractElement::safeStr($value) : $value
                );

            } else {

                $children[] = new Field($key, $value);

            }

        }

        return new Record(static::getRecordIdentifier(), $children);
    }

}