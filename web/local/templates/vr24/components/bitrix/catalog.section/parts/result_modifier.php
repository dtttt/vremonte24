<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arResult['jsParams'] = array(
    'visual' => array(
        'id' => 'CT_BCS_PARTS_' . $this->GetComponent()->randString(),
    ),
);

foreach($arResult['ITEMS'] as &$arItem)
{
    $arItem['PICTURE'] = Array();
    if ($arItem['DETAIL_PICTURE'])
    {
        $arItem['PICTURE'] = array(
            'PICTURE' => &$arItem['DETAIL_PICTURE'],
            'TITLE' => $arItem['DETAIL_PICTURE']['TITLE'],
            'ALT' => $arItem['DETAIL_PICTURE']['ALT'],
        );
    }
    elseif ($arItem['PREVIEW_PICTURE'])
    {
        $arItem['PICTURE'] = array(
            'PICTURE' => &$arItem['PREVIEW_PICTURE'],
            'TITLE' => $arItem['PREVIEW_PICTURE']['TITLE'],
            'ALT' => $arItem['PREVIEW_PICTURE']['ALT'],
        );
    }
    $arPict = &$arItem['PICTURE'];
    $arPict['THUMB'] = \CFile::ResizeImageGet(
        $arPict['PICTURE'],
        array("width" => "160", "height" =>"160"),
        BX_RESIZE_IMAGE_EXACT,
        true
    );
    unset($arPict);
}
unset($arItem);