<?
namespace Tools\Vr24;

class IblockVote
{
    public static function init(&$arResult, &$arParams, &$obj)
    {
        $component = $obj->__component;
        //01*
        //Для скрытия параметров от злых людей сохраним их в сессии,
        //а в публичку отдадим ключ.
        //02*
        //Эти параметры (пока один) так и так доступны через URL и
        //защищать его нет особого смысла (только сессия распухнет)
        $arSessionParams = array(
            "PAGE_PARAMS" => array("ELEMENT_ID"),
        );
        //03*
        //Пробегаем по параметрам чщательно складывая их в хранилище
        foreach($arParams as $k=>$v)
            if(strncmp("~", $k, 1) && !in_array($k, $arSessionParams["PAGE_PARAMS"]))
                $arSessionParams[$k] = $v;
        //04*
        //Эти "параметры" нам понадобятся для правильного подключения компонента в AJAX вызове
        $arSessionParams["COMPONENT_NAME"] = $component->GetName();
        $arSessionParams["TEMPLATE_NAME"] = $component->GetTemplateName();
        if($parent = $component->GetParent())
        {
            $arSessionParams["PARENT_NAME"] = $parent->GetName();
            $arSessionParams["PARENT_TEMPLATE_NAME"] = $parent->GetTemplateName();
            $arSessionParams["PARENT_TEMPLATE_PAGE"] = $parent->GetTemplatePage();
        }
        //05*
        //а вот и ключ!
        $idSessionParams = md5(serialize($arSessionParams));

        //06*
        //Модифицируем arResult компонента.
        //Эти данные затем будут извлекаться из кеша
        //И записываться в сессию
        $component->arResult["AJAX"] = array(
            "SESSION_KEY" => $idSessionParams,
            "SESSION_PARAMS" => $arSessionParams,
        );

        //07*
        //Эта переменная для использования в шаблоне
        $arResult["~AJAX_PARAMS"] = array(
            "SESSION_PARAMS" => $idSessionParams,
            "PAGE_PARAMS" => array(
                "ELEMENT_ID" => $arParams["ELEMENT_ID"],
            ),
            "sessid" => bitrix_sessid(),
            "AJAX_CALL" => "Y",
            "vote_id" => $arResult['ID'],
        );
        //08*
        //Она будет прозрачно передана в аяксовый пост
        $arResult["AJAX_PARAMS"] = $arResult["~AJAX_PARAMS"];
        //09*
        //Продолжение экскурсии в файле template.php
    }

    public static function jsParams(&$arResult, &$arParams, &$obj)
    {
        $arResult['jsParams'] = array(
            'visual' => array(
                'id' => 'CT_BIV_' . $obj->GetComponent()->randString(),
            ),
            'ajaxPath' => $obj->GetComponent()->getPath().'/component.php',
            'ajaxParams' => $arResult['AJAX_PARAMS'],
        );
        $obj->GetComponent()->SetResultCacheKeys(array('jsParams'));
    }

    public static function componentEpilogJsParams(&$arResult, &$arParams, &$obj)
    {
        $arResult['jsParams']['votable'] = (!isset($_SESSION["IBLOCK_RATING"][$arParams['ELEMENT_ID']]) && 'Y' != $arParams['READ_ONLY']);
    }

    public static function init2(&$arResult, &$arParams, &$obj)
    {
        global $APPLICATION;
        \CJSCore::Init(array("ajax"));
//Let's determine what value to display: rating or average ?
        if($arParams["DISPLAY_AS_RATING"] == "vote_avg")
        {
            if($arResult["PROPERTIES"]["vote_count"]["VALUE"])
                $arResult['votesValue'] = round($arResult["PROPERTIES"]["vote_sum"]["VALUE"]/$arResult["PROPERTIES"]["vote_count"]["VALUE"], 2);
            else
                $arResult['votesValue'] = 0;
        }
        else
        {
            $arResult['votesValue'] = intval($arResult["PROPERTIES"]["rating"]["VALUE"]);
        }

        $arResult['votesCount'] = intval($arResult["PROPERTIES"]["vote_count"]["VALUE"]);

        if(isset($arParams["AJAX_CALL"]) && $arParams["AJAX_CALL"]=="Y")
        {
            $APPLICATION->RestartBuffer();

            die(json_encode( array(
                    "value" => $arResult['votesValue'],
                    "votes" => $arResult['votesCount']
                )
            ));
        }
    }
}