<?php

namespace Afonya\Tst;

use Bitrix\Main\Entity;

class ExportTable extends Entity\DataManager {
    public static function getTableName() {
        return 'afonya_tst_export';
    }

    public static function getMap() {
        return array(
            new Entity\IntegerField( 'ID', [ 'primary' => true, 'autocomplete' => true ] ),
            new Entity\IntegerField( 'ORDER_ID' ),
            new Entity\IntegerField( 'CUSTOMER_ID' ),
            new Entity\FloatField( 'SUM' ),
            new Entity\FloatField( 'DISCOUNT' ),
            new Entity\DatetimeField( 'EXPORTED' )
        );
    }
}