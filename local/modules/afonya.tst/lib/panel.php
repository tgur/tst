<?php

class Panel {
    public static function Buttons() {
        AddMessage2Log( "!!!!!!!!!!!!!!!" );
// получим уровень доступа к модулю "Веб-формы"
        //$FORM_RIGHT = $APPLICATION->GetUserRight( "form" );
// если доступ есть то

// добавим в панель кнопку ведущую на список веб-форм
        global $APPLICATION;
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