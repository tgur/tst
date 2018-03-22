<?php
namespace Afonya\Tst;
class Order {
    /**
     * Обнулить сумму оплаты при создании заказа
     * @param \Bitrix\Main\Event $event
     */
    public static function SetPayToZero($event) {
        $order = $event->getParameter('ENTITY');
        // Только для нового заказа
        if ($order->getId() == 0) {
            $order->getPaymentCollection()->current()->setField( "SUM", 0 );
        }
    }
}