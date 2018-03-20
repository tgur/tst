<?php

use Bitrix\Main\ModuleManager;


Class afonya_tst extends CModule {
    public function __construct() {
        $arModuleVersion = array();

        include __DIR__ . '/version.php';

        if ( is_array( $arModuleVersion ) && array_key_exists( 'VERSION', $arModuleVersion ) ) {
            $this->MODULE_VERSION      = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }

        $this->MODULE_ID           = 'afonya.tst';
        $this->MODULE_NAME         = '�������� ������';
        $this->MODULE_DESCRIPTION  = '������ ��� ��������� �������. ������� ������';
        $this->MODULE_GROUP_RIGHTS = 'N';
        $this->PARTNER_NAME        = '�����';
        $this->PARTNER_URI         = 'http://afonya-spb.ru';
    }

    function DoInstall() {
        ModuleManager::registerModule($this->MODULE_ID);
    }

    function DoUninstall() {
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }
}