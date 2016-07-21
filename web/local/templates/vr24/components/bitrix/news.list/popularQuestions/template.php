<?if (!empty($arResult['ITEMS'])):?>
    <h3>Популярные вопросы</h3>
    <div class="grid-white scrollbar" style="height: 520px;">
        <?foreach($arResult['ITEMS'] as $arItem):?>
            <div class="item">
                <div class="title">
                    <?=$arItem['NAME']?>
                </div>
                <div class="text">
                    <?=$arItem['DETAIL_TEXT']?>
                </div>
                <div class="stats clearfix">
                    <div class="text"><i><?=$arItem['DISPLAY_PROPERTIES']['MANUFACTURER']['DISPLAY_VALUE']?></i></div>
                    <div class="views"></div>
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:iblock.vote",
                        "",
                        Array(
                            "CACHE_TIME" => $arParams['CACHE_TIME'],
                            "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                            "ELEMENT_ID" => $arItem['ID'],
                            "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                            "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
                            "MAX_VOTE" => "5",
                            "MESSAGE_404" => "",
                            "SET_STATUS_404" => "N",
                            "VOTE_NAMES" => array("1", "2", "3", "4", "5", ""),
                        ),
                        $component
                    );?>
                </div>
            </div>
        <?endforeach?>
    </div>
<?endif?>