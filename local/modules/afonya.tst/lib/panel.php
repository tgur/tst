<?php
namespace Afonya\Tst;
class Panel {
    public static function Buttons() {
        global $USER;
        global $APPLICATION;
        if ($USER->IsAdmin()){
            $APPLICATION->AddPanelButton( [
                "HREF"      => "/bitrix/admin/sale_order.php",
                "SRC"       => "/local/modules/afonya.tst/images/order.png",
                "TEXT" => "Заказы",
                "ALT"       => "Заказы",
                "HINT"      => [
                    "TITLE" => "Заказы",
                    "TEXT"  => "Перейти на страницу с заказами"
                ],
                "MAIN_SORT" => 300,
                "SORT"      => 100
            ] );
        }
    }
}