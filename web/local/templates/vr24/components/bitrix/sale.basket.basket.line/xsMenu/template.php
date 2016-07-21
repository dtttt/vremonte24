<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(false);?>
<?if ($arResult['AJAX_TEMPLATE'] != 'Y'):?>
    <div id="<?=$arResult['jsParams']['visual']['id']?>">
<?endif?>
    <a href="javascript:void(0)" class="col-xs-2 xs-col xs-btn xs-cart-btn<?=($arParams['OPEN'] == 'Y' ? ' active' : '')?>">
        <div class="xs-top-icon xs-cart-icon"></div>
        <div class="xs-cart-count"<?=($arParams['OPEN'] == 'Y' ? ' style="display:none"' : '')?>><?=$arResult['NUM_PRODUCTS']?></div>
    </a>
<?if ($arResult['AJAX_TEMPLATE'] != 'Y'):?>
    </div>
<?endif?>
<?if ($arResult['AJAX_TEMPLATE'] != 'Y'):?>
    <script type="text/javascript">
        var <?=$arResult['jsParams']['visual']['id']?> = new CT_SBBL_XSMENU(<?=CUtil::PhpToJSObject($arResult['jsParams'], false, true, true);?>);
    </script>
<?endif?>