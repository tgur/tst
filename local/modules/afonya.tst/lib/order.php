<?php

namespace Afonya\Tst;
class Order {
    /**
     * ќбнулить сумму оплаты при создании заказа
     *
     * @param \Bitrix\Main\Event $event
     */
    static function SetPayToZero( $event ) {
        $order = $event->getParameter( 'ENTITY' );
        // “олько дл€ нового заказа
        if ( $order->getId() == 0 ) {
            $order->getPaymentCollection()->current()->setField( "SUM", 0 );
        }
    }

    /**
     * Ёкспорт заказа в XML
     *
     * @param \Bitrix\Main\Event $event
     *
     * @throws
     */
    static function Export( $event ) {
        /**
         * @var \Bitrix\Sale\Order $order
         */
        $order  = $event->getParameter( 'ENTITY' );
        $fields = [];

        $orderXML = new \SimpleXMLElement( "<order></order>" );
        $orderXML->addChild( 'id', $order->getId() );
        $fields['id'] = $order->getId() . "\n";
        $orderXML->addChild( 'customer', $order->getUserId() );
        $orderXML->addChild( 'status', $order->getField( "STATUS_ID" ) );
        $fields['status'] = $order->getField( 'STATUS_ID' ) . "\n";
        $orderXML->addChild( 'total', $order->getField( "PRICE" ) );
        $fields['total'] = $order->getField( "PRICE" ) . "\n";
        if ( $order->getField( "STORE_ID" ) ) {
            $orderXML->addChild( 'store', $order->getField( "STORE_ID" ) );
            $fields['store'] = $order->getField( "STORE_ID" ) . "\n";
        } else {
            $fields['store'] = '';
        }
        $basket      = \Bitrix\Sale\Basket::loadItemsForOrder( $order );
        $basketItems = [];
        $discount    = '';
        foreach ( $basket as $basketItem ) {
            $basketItems[] =
                $basketItem->getProductId() . ":" .
                $basketItem->getQuantity() . ":" .
                $basketItem->getFinalPrice();
            $discount      += $basketItem->getDiscountPrice() * $basketItem->getQuantity();
        }
        $fields['basket'] = implode( ';', $basketItems ) . "\n";

        $fields['customer'] = $basket->getFUserId() . "\n";

        $propertyCollection = $order->getPropertyCollection();
        $fields['email']    = $propertyCollection->getUserEmail()->getValue() . "\n";
        $fields['fio']      = $propertyCollection->getPayerName()->getValue() . "\n";
        $fields['phone']    = $propertyCollection->getPhone()->getValue() . "\n";

        foreach ( $propertyCollection as $propertyItem ) {
            if ( $propertyItem->getField( 'CODE' ) == 'LOCATION' ) {
                $location = \Bitrix\Sale\Location\LocationTable::getByCode( $propertyItem->getValue()
                    , [
                        'select' => array( '*', 'NAME_RU' => 'NAME.NAME' )
                    ] )->fetch();
                if ( $location ) {
                    $fields["city"] = $location['NAME_RU'];
                } else {
                    $fields["city"] = "нет";
                }
            }
        }

        $export = "{$fields['id']}{$fields['customer']}{$fields['status']}{$fields['total']}{$fields['store']}";
        $export .= "{$fields['basket']}{$fields['email']}{$fields['fio']}{$fields['phone']}{$fields['city']}";

        $fileName = \Bitrix\Main\Application::getDocumentRoot() . '/upload/crm/order/' . $order->getId() . '.www';

        file_put_contents( $fileName, $export );

        /* ≈сли нужно вести лог изменений и записывать каждый факт записи,
        то убрать выборку и условие и оставить только ExportTable::add */
        $r = ExportTable::getList( [ 'filter' => [ "ORDER_ID" => $order->getId() ] ] )->fetch();
        AddMessage2Log($r);
        if ( $r !== false ) {
            ExportTable::update(
                $r['ID'],
                [
                    'ORDER_ID'    => $fields['id'],
                    'CUSTOMER_ID' => $fields['customer'],
                    'SUM'         => $fields['total'],
                    'DISCOUNT'    => $discount,
                    'EXPORTED'    => \Bitrix\Main\Type\DateTime::createFromTimestamp( time() )
                ] );
        } else {
            ExportTable::add( [
                'ORDER_ID'    => $fields['id'],
                'CUSTOMER_ID' => $fields['customer'],
                'SUM'         => $fields['total'],
                'DISCOUNT'    => $discount,
                'EXPORTED'    => \Bitrix\Main\Type\DateTime::createFromTimestamp( time() )
            ] );
        }


    }


}