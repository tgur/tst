<?php
use Bitrix\Main\Loader;
Loader::includeModule("afonya.tst");
Loader::registerAutoLoadClasses( 'afonya.tst', [
    'Panel' => 'lib/panel.php',
] );
