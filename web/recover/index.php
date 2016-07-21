<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Восстановление пароля");?>
<?$GLOBALS['APPLICATION']->IncludeComponent(
	"bitrix:system.auth.forgotpasswd",
	"",
	Array(
		"AUTH_RESULT" => $GLOBALS['APPLICATION']->arAuthResult,
	)
)?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>