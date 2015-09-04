<?php namespace Vdbf\Components\Cashweb\Records;

class Relation extends AbstractRecord
{

    const ID = '0101';

    const NAME = '0103';

    const ATTENTION = '0104';

    const ADDRESS = '0105';

    const ZIP_CITY = '0107';

    const IBAN = '0110';

    static $requiredFields = ['ID', 'NAME', 'ZIP_CITY'];

    static $safeStrFields = ['NAME'];

    static $recordIdentifier = '0101';

}