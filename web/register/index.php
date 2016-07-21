<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Регистрация");?>
<?$GLOBALS['APPLICATION']->IncludeComponent(
	"bitrix:system.auth.registration",
	"",
	Array(
		"AUTH_RESULT" => $GLOBALS['APPLICATION']->arAuthResult,
	)
)?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>