<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<?if (!empty($arResult['ITEMS'])):?>
    <div class="bottom-menu row hidden-xs">
        <div class="col-xs-6 col-sm-6">
            <?$i = 0; $l = ceil(count($arResult['ITEMS']) / 2);?>
            <?foreach($arResult['ITEMS'] as $arItem):?>
                <?if (++$i > $l) break;?>
                <a href="<?=$arItem['LINK']?>"><?=$arItem['TEXT']?></a>
            <?endforeach?>
        </div>
        <div class="col-xs-6 col-sm-6">
            <?$i = 0; $l = ceil(count($arResult['ITEMS']) / 2);?>
            <?foreach($arResult['ITEMS'] as $arItem):?>
                <?if (++$i <= $l) continue;?>
                <a href="<?=$arItem['LINK']?>"><?=$arItem['TEXT']?></a>
            <?endforeach?>
        </div>
    </div>
<?endif?>