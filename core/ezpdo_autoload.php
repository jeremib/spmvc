<?php
require_once('lib/ezpdo/ezpdo.php');
require_once(EP_SRC_RUNTIME.'/epManager.php');

require_once(EP_SRC_BASE.'/epConfig.php');

$config = new epConfig();
epManager::instance()->setConfig($config);
?>
