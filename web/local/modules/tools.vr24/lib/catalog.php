<?
namespace Tools\Vr24;

class Catalog extends Base
{
    public static function resultModifier(&$arResult, &$arParams, &$obj, $isElement = false)
    {
        if ($isElement)
            self::resultModifierElement($arResult, $arParams, $obj);
        else
            self::resultModifierElements($arResult, $arParams, $obj);
    }

    public static function resultModifierElement(&$arResult, &$arParams, &$obj)
    {
        self::pictures($arResult, $arParams, $obj);
        self::jsParams($arResult, $arParams, $obj);

        if (isset($arResult['DISPLAY_PROPERTIES']['PLUSES']))
        {
            if (count($arResult['DISPLAY_PROPERTIES']['PLUSES']['VALUE']) == 1)
            {
                $arResult['DISPLAY_PROPERTIES']['PLUSES']['DISPLAY_VALUE'] =
                    array($arResult['DISPLAY_PROPERTIES']['PLUSES']['DISPLAY_VALUE']);
            }
        }
        $GLOBALS[$arParams['REVIEWS']['FILTER_NAME']]['REVIEW_PRODUCT_VALUE'] = $arResult['ID'];
        $GLOBALS[$arParams['QUESTIONS']['FILTER_NAME']]['QUESTION_PRODUCT_VALUE'] = $arResult['ID'];

        $arResult['REVIEWS_COUNT'] = \CIBlockElement::GetList(array(), array(
            'IBLOCK_ID' => $arParams['REVIEWS']['IBLOCK_ID'],
            'ACTIVE' => 'Y',
            'PROPERTY_REVIEW_PRODUCT_VALUE' => $arResult['ID'],
        ), array());
        $arResult['QUESTIONS_COUNT'] = \CIBlockElement::GetList(array(), array(
            'IBLOCK_ID' => $arParams['QUESTIONS']['IBLOCK_ID'],
            'ACTIVE' => 'Y',
            'PROPERTY_QUESTION_PRODUCT_VALUE' => $arResult['ID'],
        ), array());
    }

    public static function resultModifierElements(&$arResult, &$arParams, &$obj)
    {

    }

    public static function pictures(&$arResult, &$arParams, &$obj)
    {
        $arResult['PICTURES'] = Array();
        if ($arResult['DETAIL_PICTURE'])
        {
            $arResult['PICTURES'][] = array(
                'PICTURE' => &$arResult['DETAIL_PICTURE'],
                'TITLE' => $arResult['DETAIL_PICTURE']['TITLE'],
                'ALT' => $arResult['DETAIL_PICTURE']['ALT'],
            );
        }
        elseif ($arResult['PREVIEW_PICTURE'])
        {
            $arResult['PICTURES'][] = array(
                'PICTURE' => &$arResult['PREVIEW_PICTURE'],
                'TITLE' => $arResult['PREVIEW_PICTURE']['TITLE'],
                'ALT' => $arResult['PREVIEW_PICTURE']['ALT'],
            );
        }
        if (!empty($arResult['DISPLAY_PROPERTIES']['MORE_PHOTO']))
        {
            if (count($arResult['DISPLAY_PROPERTIES']['MORE_PHOTO']['VALUE']) == 1)
            {
                $arResult['DISPLAY_PROPERTIES']['MORE_PHOTO']['FILE_VALUE'] =
                    array($arResult['DISPLAY_PROPERTIES']['MORE_PHOTO']['FILE_VALUE']);
            }
            foreach($arResult['DISPLAY_PROPERTIES']['MORE_PHOTO']['FILE_VALUE'] as $key => &$arFile)
            {
                $description = strlen($arResult['DISPLAY_PROPERTIES']['MORE_PHOTO']['DESCRIPTION'][$key]) ?
                    $arResult['DISPLAY_PROPERTIES']['MORE_PHOTO']['DESCRIPTION'][$key] :
                    $arResult['NAME'];
                $arResult['PICTURES'][] = array(
                    'PICTURE' => &$arFile,
                    'TITLE' => $description,
                    'ALT' => $description,
                );
            }
            unset($arFile);
        }
        foreach($arResult['PICTURES'] as &$arPict)
        {
            $arPict['PREVIEW'] = \CFile::ResizeImageGet(
                $arPict['PICTURE'],
                array("width" => "530", "height" =>"530"),
                BX_RESIZE_IMAGE_EXACT,
                true
            );
            $arPict['THUMB'] = \CFile::ResizeImageGet(
                $arPict['PICTURE'],
                array("width" => "120", "height" =>"120"),
                BX_RESIZE_IMAGE_EXACT,
                true
            );
            $arPict['XS'] = \CFile::ResizeImageGet(
                $arPict['PICTURE'],
                array("width" => "280", "height" =>"280"),
                BX_RESIZE_IMAGE_EXACT,
                true
            );
        }
        unset($arPict);
    }

    public static function jsParams(&$arResult, &$arParams, &$obj)
    {
        $arResult['jsParams'] = array(
            'visual' => array(
                'id' => 'CT_BCE_' . $obj->GetComponent()->randString(),
            ),
            /*'siteId' => SITE_ID,
            'ajaxPath' => $obj->GetComponent()->getPath().'/ajax.php',
            'templateName' => $obj->GetName(),
            'arParams' => $arParams,*/
        );
    }
}