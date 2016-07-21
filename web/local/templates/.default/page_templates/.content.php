<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
$TEMPLATE['default.php'] = Array('name' => GetMessage('T_PAGE_TEMPLATE_DEFAULT'), 'sort' => 1);
$TEMPLATE['content.php'] = Array('name' => GetMessage('T_PAGE_TEMPLATE_CONTENT'), 'sort' => 2);
$TEMPLATE['utility.php'] = Array('name' => GetMessage('T_PAGE_TEMPLATE_UTILITY'), 'sort' => 3);
$TEMPLATE['utility_visual.php'] = Array('name' => GetMessage('T_PAGE_TEMPLATE_UTILITY_VISUAL'), 'sort' => 4);
$TEMPLATE['empty.php']   = Array('name' => GetMessage('T_PAGE_TEMPLATE_EMPTY'), 'sort' => 5);
$TEMPLATE['admin.php']   = Array('name' => GetMessage('T_PAGE_TEMPLATE_ADMIN'), 'sort' => 6);
// http://dev.1c-bitrix.ru/api_help/main/general/admin.section/rubric_admin_ex.php
// http://dev.1c-bitrix.ru/api_help/main/general/admin.section/rubric_edit_ex.php
// http://dev.1c-bitrix.ru/api_help/main/general/pageplan.php