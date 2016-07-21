<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Смена пароля");?>
<?$GLOBALS['APPLICATION']->IncludeComponent(
	"bitrix:system.auth.changepasswd",
	"",
	Array(
		"AUTH_RESULT" => $GLOBALS['APPLICATION']->arAuthResult,
	)
)?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>