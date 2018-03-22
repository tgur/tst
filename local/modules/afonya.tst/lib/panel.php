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
                "TEXT" => "������",
                "ALT"       => "������",
                "HINT"      => [
                    "TITLE" => "������",
                    "TEXT"  => "������� �� �������� � ��������"
                ],
                "MAIN_SORT" => 300,
                "SORT"      => 100
            ] );
        }
    }
}