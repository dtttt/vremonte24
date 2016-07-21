<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<div id="<?=$arResult['jsParams']['visual']['id']?>">
    <div class="row row-product">
        <div class="col-xs-12 col-sm-8 col-left">
            <div class="row visible-xs">
                <div class="xs-product-imgs xs-product-imgs-slider">
                    <?if (!empty($arResult['PICTURES'])):?>
                        <?foreach($arResult['PICTURES'] as $arPict):?>
                            <img src="<?=$arPict['XS']['src']?>" class="img-responsive" alt="<?=$arPict['ALT']?>">
                        <?endforeach?>
                    <?else:?>
                        <img src="http://dummyimage.com/280x280.jpg" class="img-responsive">
                    <?endif?>
                </div>
            </div>
            <div class="row hidden-xs row-imgs">
                <div class="col-sm-4 col-md-3 col-left">
                    <div class="product-thumbs product-thumbs-slider tinycarousel-vertical" style="width: 122px;">
                        <a class="buttons prev" href="javascript:void(0)"></a>
                        <div class="viewport">
                            <ul class="overview">
                                <?$i = 0;?>
                                <?if (!empty($arResult['PICTURES'])):?>
                                    <?foreach($arResult['PICTURES'] as $arPict):?>
                                        <li<?=(++$i == 1 ? ' class="active"' : '')?>><a href="<?=$arPict['PREVIEW']['src']?>" data-original-src="<?=$arPict['PICTURE']['SRC']?>"><img src="<?=$arPict['THUMB']['src']?>" alt="<?=$arPict['ALT']?>" title="<?=$arPict['TITLE']?>" class="img-responsive"></a></li>
                                    <?endforeach?>
                                <?else:?>
                                    <li<?=(++$i == 1 ? ' class="active"' : '')?>><a href="http://dummyimage.com/530x530.jpg" data-original-src="http://dummyimage.com/800x800.jpg"><img src="http://dummyimage.com/120x120.jpg" class="img-responsive"></a></li>
                                <?endif?>
                            </ul>
                        </div>
                        <a class="buttons next" href="javascript:void(0)"></a>
                    </div>
                </div>
                <div class="col-sm-8 col-md-9 col-right">
                    <div class="product-big-img">
                        <?if (!empty($arResult['PICTURES'])):?>
                            <?foreach($arResult['PICTURES'] as $arPict):?>
                                <a href="<?=$arPict['PICTURE']['SRC']?>">
                                    <img src="<?=$arPict['PREVIEW']['src']?>" class="img-responsive" alt="<?=$arPict['ALT']?>" title="<?=$arPict['TITLE']?>">
                                </a>
                                <?break;?>
                            <?endforeach?>
                        <?else:?>
                            <a href="http://dummyimage.com/803x803.jpg">
                                <img src="http://dummyimage.com/530x530.jpg" class="img-responsive">
                            </a>
                        <?endif?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-right">
            <div class="product-attributes">
                <h3 class="title"><?=$arResult['NAME']?></h3>
                <div class="borders-1 article">
                    Артикул: <strong><?=$arResult['DISPLAY_PROPERTIES']['CML2_ARTICLE']['DISPLAY_VALUE']?></strong>
                </div>
                <div class="manufacturer">
                    <?=$arResult['DISPLAY_PROPERTIES']['CML2_MANUFACTURER']['DISPLAY_VALUE']?>
                </div>
                <div class="price"><?=$arResult['PRICES']['Базовая']['PRINT_DISCOUNT_VALUE_VAT']?></div>
                <?if ($arResult['CAN_BUY']):?>
                    <div class="buy">
                        <a href="<?=$arResult['BUY_URL']?>" class="btn btn-transparent-primary">В корзину</a>
                    </div>
                <?endif?>
                <?if (!empty($arResult['DISPLAY_PROPERTIES']['PLUSES'])):?>
                    <ul>
                        <?foreach($arResult['DISPLAY_PROPERTIES']['PLUSES']['DISPLAY_VALUE'] as $value):?>
                            <li><?=$value?></li>
                        <?endforeach?>
                    </ul>
                <?endif?>
                <div class="stats">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:iblock.vote",
                        "",
                        Array(
                            "CACHE_TIME" => $arParams['CACHE_TIME'],
                            "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                            "ELEMENT_ID" => $arResult['ID'],
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
                <div class="share">
                    <div class="title">Поделиться</div>
                    <div class="buttons">
                        <img src="/img/dummy_social.gif">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-8">
            <div class="product-tabs hidden-xs">
                <a href="javascript:void(0)" class="btn btn-transparent-primary active product-tab" data-tab="description">Описание</a>
                <a href="javascript:void(0)" class="btn btn-transparent-primary product-tab" data-tab="reviews">Отзывы <span class="text-red"><?=$arResult['REVIEWS_COUNT']?></span></a>
                <a href="javascript:void(0)" class="btn btn-transparent-primary product-tab" data-tab="qa">Вопросы и ответы <span class="text-red"><?=$arResult['QUESTIONS_COUNT']?></span></a>
            </div>
            <div class="product-tab-content" data-tab="description">
                <div class="visible-xs">
                    <h3>Описание</h3>
                </div>
                <?=$arResult['DETAIL_TEXT']?>
            </div>
            <div class="product-tab-content" data-tab="reviews" style="display:none;">
                <?$GLOBALS['APPLICATION']->IncludeComponent(
                   "bitrix:news.list",
                   "reviews",
                    $arParams['REVIEWS']
                )?>
            </div>
            <div class="product-tab-content" data-tab="qa" style="display:none;">
                <?$GLOBALS['APPLICATION']->IncludeComponent(
                    "bitrix:news.list",
                    "questions",
                    $arParams['QUESTIONS']
                )?>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4">
            <?if (isset($arResult['DISPLAY_PROPERTIES']['VIDEO'])):?>
                <h3>Видео инструкции</h3>
                <div class="product-video-one-row video-one-row product-video-slider">
                    <?foreach($arResult['DISPLAY_PROPERTIES']['VIDEO']['VALUE'] as $key => $value):?>
                        <div class="item">
                            <a href="<?=$value?>" class="fancybox fancybox.iframe">
                                <div class="img">
                                    <img src="http://dummyimage.com/140x78.jpg" class="img-responsive">
                                </div>
                                <div class="title">
                                    <?=$arResult['DISPLAY_PROPERTIES']['VIDEO']['DESCRIPTION'][$key]?>
                                </div>
                            </a>
                        </div>
                    <?endforeach?>
                </div>
            <?endif?>
        </div>
    </div>
</div>
<script type="text/javascript">
    var <?=$arResult['jsParams']['visual']['id']?> = new CT_BCE_CATALOG(<?=CUtil::PhpToJSObject($arResult['jsParams'], false, true, true);?>);
</script>