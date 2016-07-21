<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<?if (!empty($arResult['ITEMS'])):?>
    <hr>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-6">
                <ul class="second-menu-left second-menu">
                    <?$i = 0; $l = ceil(count($arResult['ITEMS']) / 2);?>
                    <?foreach($arResult['ITEMS'] as $arItem):?>
                        <?if (++$i > $l) break;?>
                        <li><a href="<?=$arItem['LINK']?>"><?=$arItem['TEXT']?></a></li>
                    <?endforeach?>
                </ul>
            </div>
            <div class="col-xs-6">
                <ul class="second-menu-right second-menu">
                    <?$i = 0; $l = ceil(count($arResult['ITEMS']) / 2);?>
                    <?foreach($arResult['ITEMS'] as $arItem):?>
                        <?if (++$i <= $l) continue;?>
                        <li><a href="<?=$arItem['LINK']?>"><?=$arItem['TEXT']?></a></li>
                    <?endforeach?>
                </ul>
            </div>
        </div>
    </div>
<?endif?>
<hr style="margin: 20px 0 0;">
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-6" style="padding: 0; margin-right: -4px;">
            <nav class="navbar navbar-default third-menu-left third-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown navbar-link-style-2 navbar-default-link-karta">
                        <a href="javascript:void(0)" class="dropdown-toggle text-nowrap" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Красноярск <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0)">Тобольск</a></li>
                            <li><a href="javascript:void(0)">Екатеринбург</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="col-xs-6" style="padding: 0;">
            <nav class="navbar navbar-default third-menu-right third-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown navbar-link-style-2">
                        <a href="javascript:void(0)" class="dropdown-toggle text-nowrap" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Магазины <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0)">на ул. Пермякова</a></li>
                            <li><a href="javascript:void(0)">на ул. Геологоразведчиков</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<hr style="margin: 0">
