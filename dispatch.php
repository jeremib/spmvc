<?
require 'core/setup.php';

$spmvc = new spMvc(new Savant3, epManager::instance());
$spmvc->dispatch($_GET['route']);
