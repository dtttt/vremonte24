<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");?>
<?$GLOBALS['APPLICATION']->IncludeComponent(
	"bitrix:catalog",
	"",
	Tools\Params\Catalog::vr24()
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>