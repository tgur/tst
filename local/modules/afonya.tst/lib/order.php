<?php
namespace Afonya\Tst;
class Order {
    /**
     * �������� ����� ������ ��� �������� ������
     * @param \Bitrix\Main\Event $event
     */
    public static function SetPayToZero($event) {
        $order = $event->getParameter('ENTITY');
        // ������ ��� ������ ������
        if ($order->getId() == 0) {
            $order->getPaymentCollection()->current()->setField( "SUM", 0 );
        }
    }
}