<?php

use Bitrix\Main\EventManager;
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
        $this->MODULE_NAME         = 'Тестовый модуль';
        $this->MODULE_DESCRIPTION  = 'Модуль для тестового задания. Тимофей Гурьев';
        $this->MODULE_GROUP_RIGHTS = 'N';
        $this->PARTNER_NAME        = 'Афоня';
        $this->PARTNER_URI         = 'http://afonya-spb.ru';
    }

    function DoInstall() {
        ModuleManager::registerModule($this->MODULE_ID);
        EventManager::getInstance()->registerEventHandler('main', 'OnBeforeProlog',
            $this->MODULE_ID,'\Afonya\Tst\Panel', 'Buttons');
        EventManager::getInstance()->registerEventHandler('sale', 'OnSaleOrderBeforeSaved',
            $this->MODULE_ID,'\Afonya\Tst\Order', 'SetPayToZero');
    }

    function DoUninstall() {
        EventManager::getInstance()->unRegisterEventHandler('main','OnBeforeProlog',
            $this->MODULE_ID,'\Afonya\Tst\Panel', 'Buttons');
        EventManager::getInstance()->unRegisterEventHandler('sale','OnSaleOrderBeforeSaved',
            $this->MODULE_ID,'\Afonya\Tst\Order', 'SetPayToZero');
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }


}