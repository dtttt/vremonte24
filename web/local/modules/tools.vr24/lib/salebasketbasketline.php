<?
namespace Tools\Vr24;

class SaleBasketBasketLine extends Base
{
    public static function jsParams(&$arResult, &$arParams, &$obj)
    {
        $arResult['jsParams'] = array(
            'visual' => array(
                'id' => 'cart' . $obj->GetComponent()->randString(),
            ),
            'siteId' => SITE_ID,
            'ajaxPath' => $obj->GetComponent()->getPath().'/ajax.php',
            'templateName' => $obj->GetName(),
            'arParams' => $arParams,
        );
    }

    public static function numProducts(&$arResult, &$arParams, &$obj)
    {
        $arResult['NUM_PRODUCTS'] = 0;
        foreach($arResult['CATEGORIES']['READY'] as $arItem)
        {
            $arResult['NUM_PRODUCTS'] += $arItem['QUANTITY'];
        }
    }

    public static function resizeImage(&$arResult, &$arParams, &$obj)
    {
        foreach($arResult['CATEGORIES']['READY'] as &$arItem)
        {
            $arPicture = null;
            if (isset($arItem["PREVIEW_PICTURE"]) && intval($arItem["PREVIEW_PICTURE"]) > 0)
                $arPicture = \CFile::GetFileArray($arItem["PREVIEW_PICTURE"]);
            elseif (isset($arItem["DETAIL_PICTURE"]) && intval($arItem["DETAIL_PICTURE"]) > 0)
                $arPicture = \CFile::GetFileArray($arItem["DETAIL_PICTURE"]);
            if ($arPicture)
                $arItem['PICTURE'] = \CFile::ResizeImageGet(
                    $arPicture,
                    array("width" => "40", "height" =>"40"),
                    BX_RESIZE_IMAGE_PROPORTIONAL,
                    true
                );
        }
    }
}