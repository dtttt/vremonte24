<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');?>
<?
if ($_REQUEST['change_password']=="yes")
{
	$profilePaths = Tools\Params\Common::profilePaths();
	$params = array();
	foreach(array("lang", "USER_CHECKWORD", "USER_LOGIN") as $value)
	{
		if (isset($_REQUEST[$value]))
			$params[$value] = $_REQUEST[$value];
	}

	$redirectUrl = $profilePaths['CHANGE_PASSWORD_URL'];
	$redirectUrl = Tools\Snippets\Common::getPageParam($redirectUrl, $params);
	LocalRedirect($redirectUrl);
}
elseif ($_REQUEST['confirm_registration'] == "yes")
{
	$profilePaths = Tools\Params\Common::profilePaths();
	$params = array();
	foreach(array("confirm_user_id", "confirm_code") as $value)
	{
		if (isset($_REQUEST[$value]))
			$params[$value] = $_REQUEST[$value];
	}

	$redirectUrl = $profilePaths['CONFIRM_REGISTER_URL'];
	$redirectUrl = Tools\Snippets\Common::getPageParam($redirectUrl, $params);
	LocalRedirect($redirectUrl);
}
else
{
	@define("ERROR_404", "Y");
}
?>
<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>
