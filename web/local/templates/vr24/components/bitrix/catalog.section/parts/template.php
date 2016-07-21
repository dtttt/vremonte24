<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult['ITEMS'])):?>
    <div class="row" id="<?=$arResult['jsParams']['visual']['id']?>">
        <div class="col-xs-12">
            <hr>
            <h3>Запчасти для устройства</h3>
            <div class="products-spares-slider products-one-row">
                <?foreach($arResult['ITEMS'] as $arItem):?>
                    <div class="item">
                        <div class="img">
                            <?if ($arItem['PICTURE']['THUMB']):?>
                                <img src="<?=$arItem['PICTURE']['THUMB']['src']?>" alt="<?=$arItem['PICTURE']['ALT']?>" title="<?=$arItem['PICTURE']['TITLE']?>">
                            <?else:?>
                                <img src="http://dummyimage.com/160x160.jpg" alt="<?=$arItem['NAME']?>" title="<?=$arItem['NAME']?>">
                            <?endif?>
                        </div>
                        <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="title text-info">
                            <?=$arItem['NAME']?>
                        </a>
                        <div class="price">
                            <?=$arItem['PRICES']['Базовая']['PRINT_DISCOUNT_VALUE_VAT']?>
                        </div>
                        <?if ($arItem['CAN_BUY']):?>
                            <div class="stock in">
                                есть в наличии
                            </div>
                        <?else:?>
                            <div class="stock out">
                                на заказ
                            </div>
                        <?endif?>
                        <?if ($arItem['CAN_BUY']):?>
                            <div class="buy">
                                <a href="<?=$arItem['BUY_URL']?>" class="btn btn-transparent-primary">В корзину</a>
                            </div>
                        <?endif?>
                    </div>
                <?endforeach?>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var <?=$arResult['jsParams']['visual']['id']?> = new CT_BNL_PARTS(<?=CUtil::PhpToJSObject($arResult['jsParams'], false, true, true);?>);
    </script>
<?endif?>