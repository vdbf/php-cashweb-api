<?php namespace Vdbf\Components\Cashweb\Records;

class LedgerMutation extends AbstractRecord
{

    /**
     * Relation identifier
     *
     * @format N<6>
     */
    const RELATION_ID = '0101';

    /**
     * Ledger identifier
     *
     * @format S<6>
     */
    const LEDGER_ID = '0201';

    /**
     * Journal identifier
     *
     * @format S<6>
     */
    const JOURNAL_ID = '0901';

    /**
     * Invoice identifier
     *
     * @format N<6>
     */
    const INVOICE_ID = '0309';

    /**
     * Unique number per YEAR and JOURNAL
     *
     * @format N<6>
     */
    const SEQUENCE_ID = '0303';

    /**
     * Ledger description
     *
     * @format L<25>
     */
    const DESCRIPTION = '0306';

    /**
     * Booking period
     *
     * @format YYMM
     */
    const BOOKING_PERIOD = '0301';

    /**
     * Booking date
     *
     * @format YYMMDD
     */
    const BOOKING_DATE = '0302';

    /**
     * Amount (BEDRAG)
     *
     * @format I<12,2>
     */
    const AMOUNT = '0307';

    /**
     * Quantity (AANTAL)
     *
     * @format I<12,2>
     */
    const QUANTITY = '0305';


    /**
     * Subadministation (Subadministratie)
     * @format S<6>
     */
    const SUB_ADMINISTRATION = '0701';

    /**
     * Reference (Kenmerk)
     * @format S<13>
     */
    const REFERENCE = '0711';

    /**
     * Required fields for this record
     *
     * @var array
     */
    static $requiredFields = ['BOOKING_DATE', 'JOURNAL_ID', 'SEQUENCE_ID', 'LEDGER_ID', 'AMOUNT'];

    /**
     * Ledger mutation record identifier
     *
     * @var string
     */
    static $recordIdentifier = '0301';

}