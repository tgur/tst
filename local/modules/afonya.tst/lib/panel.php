<?php

class Panel {
    public static function Buttons() {
        AddMessage2Log( "!!!!!!!!!!!!!!!" );
// ������� ������� ������� � ������ "���-�����"
        //$FORM_RIGHT = $APPLICATION->GetUserRight( "form" );
// ���� ������ ���� ��

// ������� � ������ ������ ������� �� ������ ���-����
        global $APPLICATION;
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