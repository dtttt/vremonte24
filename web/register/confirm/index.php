<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Подтверждение регистрации");?>
<?$GLOBALS['APPLICATION']->IncludeComponent(
	"bitrix:system.auth.confirmation",
	"",
	Array(
		"AUTH_RESULT" => $GLOBALS['APPLICATION']->arAuthResult,
	)
)?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>