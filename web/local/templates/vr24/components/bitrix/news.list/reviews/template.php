<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="visible-xs">
    <hr>
    <h3>Отзывы <span class="text-red"><?=count($arResult['ITEMS'])?></span></h3>
</div>
<div class="feedback-block product-feedback-block">
    <?if (!empty($arResult['ITEMS'])):?>
        <?foreach($arResult['ITEMS'] as $arItem):?>
            <div class="row item">
                <div class="col-xs-12 col-sm-3">
                    <?if ($arItem['PICTURE']):?>
                        <div class="img">
                            <img src="<?=$arItem['PICTURE']['src']?>" class="img-circle" alt="<?=$arItem['PICTURE']['ALT']?>" title="<?=$arItem['PICTURE']['TITLE']?>">
                        </div>
                    <?else:?>
                        <div class="img">
                            <img src="http://dummyimage.com/70x70.jpg" class="img-circle" alt="<?=htmlspecialcharsEx($arItem['~NAME'])?>" title="<?=htmlspecialcharsEx($arItem['~NAME'])?>">
                        </div>
                    <?endif?>
                </div>
                <div class="col-xs-12 col-sm-9">
                    <div class="title"><?=$arItem['NAME']?></div>
                    <div class="text"><?=$arItem['DETAIL_TEXT']?></div>
                    <div class="stats">
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
        На данный момент отзывов нет.
    <?endif?>
</div>