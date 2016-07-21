<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');?>
<?
if ($_REQUEST['change_password'] == 'yes' || $_REQUEST['confirm_registration'])
    LocalRedirect('/auth/index.php?' . http_build_query($_GET, '', '&'));
else
    @define("ERROR_404", "Y");
?>
<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>