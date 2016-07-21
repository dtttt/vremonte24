<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
foreach($arResult['ITEMS'] as &$arItem)
{
    if (isset($arItem['DISPLAY_PROPERTIES']['ANSWER_USER']))
    {
        $rsUser = CUser::GetByID($arItem['DISPLAY_PROPERTIES']['ANSWER_USER']);
        $arUser = $rsUser->Fetch();
        $fullname = $arUser['NAME'] . ' ' . $arUser['LAST_NAME'];
        if (!strlen(trim($fullname)))
            $fullname = $arUser['LOGIN'];
        $arItem['DISPLAY_PROPERTIES']['ANSWER_USER']['DISPLAY_VALUE'] = $fullname;
    }
}
unset($arItem);