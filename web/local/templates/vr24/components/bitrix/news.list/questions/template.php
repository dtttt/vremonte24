<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="visible-xs">
    <hr>
    <h3>Вопросы и ответы <span class="text-red"><?=count($arResult['ITEMS'])?></span></h3>
</div>
<div class="qa">
    <?if (!empty($arResult['ITEMS'])):?>
        <?foreach($arResult['ITEMS'] as $arItem):?>
            <div class="borders-1 item">
                <a href="javascript:void(0)" class="expand collapsed" data-toggle="collapse" data-target="#qa-expand-1"></a>
                <div class="title"><?=$arItem['NAME']?></div>
                <div class="text"><?=$arItem['DETAIL_TEXT']?></div>
                <div class="collapse" id="qa-expand-1">
                    <?if (isset($arItem['DISPLAY_PROPERTIES']['ANSWER_USER'])):?>
                        <div class="answer">
                            <div class="row item">
                                <div class="col-xs-12 col-sm-2">
                                    <div class="img">
                                        <img src="http://dummyimage.com/70x70.jpg" class="img-circle">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-10">
                                    <div class="title"><?=$arItem['DISPLAY_PROPERTIES']['ANSWER_USER']['DISPLAY_VALUE']?></div>
                                    <div class="text"><?=$arItem['DISPLAY_PROPERTIES']['ANSWER_TEXT']['DISPLAY_VALUE']?></div>
                                </div>
                            </div>
                        </div>
                    <?endif?>
                    <div class="stats">
                        <div class="text">
                            Статья: <span>Ремонт вибрации на смартфоне Nokia X6-00</span>
                        </div>
                        <div class="views">
                            13 420
                        </div>
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
            </div>
        <?endforeach?>
    <?else:?>
        На данный момент вопросов нет.
    <?endif?>
</div>
<div class="visible-xs">
    <hr style="margin: 40px 0 20px;">
</div>