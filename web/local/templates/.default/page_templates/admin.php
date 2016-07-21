<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
if (strpos( $APPLICATION->GetCurPage(), BX_ROOT.'/admin/' ) !== 0)
	$APPLICATION->AddHeadString('<base href="'.BX_ROOT.'/admin/">');
?>
<?
if(!$USER->IsAdmin())
	$APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));

// -------------------------
// Служебная часть - Начало
// -------------------------

// -------------------------
// Служебная часть - Конец
// -------------------------



require($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/include/prolog_admin_after.php");
// -------------------------
// Визуальная часть - Начало
// -------------------------
?>

<?
// -------------------------
// Визуальная часть - Конец
// -------------------------
require($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/include/epilog_admin_before.php");
?>
<?require($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/include/epilog_admin_after.php");?>