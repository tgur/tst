<? if ( ! defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true ) {
    die();
}

/**
 * @var array $arParams
 * @var array $arResult
 * @var SaleOrderAjax $component
 */

$component = $this->__component;
$component::scaleImages( $arResult['JS_DATA'], $arParams['SERVICES_IMAGES_SCALING'] );

$context = \Bitrix\Main\Application::getInstance()->getContext();
$request = $context->getRequest();
if ( strlen( $request->get( 'ORDER_ID' ) ) > 0 ) {
    $order  = \Bitrix\Sale\Order::load( $arResult['ORDER_ID'] );
    $basket = $order->getBasket();
    /**
     * @var \Bitrix\Sale\BasketItem $basketItem
     */
    foreach ( $basket as $basketItem ) {
        $discount                                            += $basketItem->getDiscountPrice() * $basketItem->getQuantity();
        $arResult['BASKET']['ITEMS'][ $basketItem->getId() ] =
            [
                'NAME'           => $basketItem->getField( 'NAME' ),
                'QUANTITY'       => $basketItem->getQuantity(),
                'BASE_PRICE'     => $basketItem->getBasePrice(),
                'DISCOUNT_PRICE' => $basketItem->getDiscountPrice(),
                'PRICE'          => $basketItem->getPrice(),
                'FINAL_SUM'      => $basketItem->getFinalPrice()
            ];
        if ($basketItem->getDiscountPrice() > 0) {
            $arResult['BASKET']['ITEMS'][ $basketItem->getId() ]['PRICE_HTML'] =
                "<span class='old-price'>{$basketItem->getBasePrice()}</span> {$basketItem->getPrice()}";
        } else {
            $arResult['BASKET']['ITEMS'][ $basketItem->getId() ]['PRICE_HTML'] =
                "{$basketItem->getPrice()}";
        }

    }
}