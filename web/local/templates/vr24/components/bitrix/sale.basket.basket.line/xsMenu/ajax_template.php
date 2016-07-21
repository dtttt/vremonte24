<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->IncludeLangFile('template.php');
$arResult['AJAX_TEMPLATE'] = 'Y';
require Bitrix\Main\Application::getDocumentRoot() . $this->GetFolder() . '/template.php';