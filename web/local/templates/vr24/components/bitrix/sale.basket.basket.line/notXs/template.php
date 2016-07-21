<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(false);?>
<?if ($arResult['AJAX_TEMPLATE'] != 'Y'):?>
    <div id="<?=$arResult['jsParams']['visual']['id']?>">
<?endif?>

<div class="text-right">
    <a href="javascript:void(0)" class="mini-korzina dotted-gray">
        Корзина
    </a>
</div>
<div class="text-right mini-korzina-value">
    В корзине <span class="text-red text-bold"><?=$arResult['NUM_PRODUCTS']?></span> <?=GetMessage('CT_SBBL_NOTXS_TOVAR_'.Tools\Snippets\Common::declension($arResult['NUM_PRODUCTS']))?>
</div>
<?if ($arResult['AJAX_TEMPLATE'] != 'Y'):?>
    </div>
<?endif?>
<?if ($arResult['AJAX_TEMPLATE'] != 'Y'):?>
    <script type="text/javascript">
        var <?=$arResult['jsParams']['visual']['id']?> = new CT_SBBL_NOTXS(<?=CUtil::PhpToJSObject($arResult['jsParams'], false, true, true);?>);
    </script>
<?endif?>
