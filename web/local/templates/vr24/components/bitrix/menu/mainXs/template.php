<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<?if (!empty($arResult['ITEMS'])):?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <ul class="first-menu">
                    <?foreach($arResult['ITEMS'] as $arItem):?>
                        <li><a href="<?=$arItem['LINK']?>"><?=$arItem['TEXT']?></a></li>
                    <?endforeach?>
                </ul>
            </div>
        </div>
    </div>
<?endif?>