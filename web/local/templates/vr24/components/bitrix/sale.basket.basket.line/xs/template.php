<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(false);
?>
<?if ($arResult['AJAX_TEMPLATE'] != 'Y'):?>
    <div class="xs-cart-block xs-block" id="<?=$arResult['jsParams']['visual']['id']?>"<?=($arParams['OPEN'] == 'Y' ? ' style="display: block"' : '')?>>
<?endif?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <div class="cart-title">В корзине <span class="text-red"><?=$arResult['NUM_PRODUCTS']?></span> <?=GetMessage('CT_SBBL_XS_TOVAR_'.Tools\Snippets\Common::declension($arResult['NUM_PRODUCTS']))?></div>
                <?if ($arParams['SHOW_PRODUCTS'] == 'Y'):?>
                    <table class="cart-positions">
                        <?foreach($arResult['CATEGORIES']['READY'] as $arItem):?>
                            <tr>
                                <td class="td-img">
                                    <?if ($arParams['SHOW_IMAGE'] == 'Y' && $arItem['PICTURE']):?>
                                        <img src="<?=$arItem['PICTURE']['src']?>">
                                    <?else:?>
                                        <img src="http://dummyimage.com/40x40.jpg">
                                    <?endif?>
                                </td>
                                <td class="td-content">
                                    <div>
                                        <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="title"><?=$arItem['NAME']?></a>
                                    </div>
                                    <div>
                                        <span class="quantity"><?=$arItem['QUANTITY']?> <?=$arItem['MEASURE_NAME']?></span>
                                        <span class="price"><?=$arItem['SUM']?></span>
                                    </div>
                                </td>
                                <td class="td-actions">
                                    <a href="javascript:void(0)" class="action-delete" data-positionId="<?=$arItem['ID']?>" data-js="<?=$arResult['jsParams']['visual']['id']?>"></a>
                                </td>
                            </tr>
                        <?endforeach?>
                    </table>
                <?endif?>
                <?if ($arResult['NUM_PRODUCTS'] > 0):?>
                    <?if ($arParams['SHOW_TOTAL_PRICE'] == 'Y'):?>
                        <div class="itog">
                            Итог: <span class="text-primary"><?=$arResult['TOTAL_PRICE']?></span>
                        </div>
                    <?endif?>
                    <?if (!$arResult['DISABLE_USE_BASKET']):?>
                        <div class="oformit">
                            <a href="<?=$arParams['PATH_TO_BASKET']?>" class="btn btn-primary btn-block">
                                Оформить
                            </a>
                        </div>
                    <?endif?>
                <?endif?>
            </div>
        </div>
    </div>
<?if ($arResult['AJAX_TEMPLATE'] != 'Y'):?>
    </div>
<?endif?>
<?if ($arResult['AJAX_TEMPLATE'] != 'Y'):?>
    <script type="text/javascript">
        var <?=$arResult['jsParams']['visual']['id']?> = new CT_SBBL_XS(<?=CUtil::PhpToJSObject($arResult['jsParams'], false, true, true);?>);
    </script>
<?endif?>
