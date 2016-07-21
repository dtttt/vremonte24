<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<nav class="navbar navbar-default hidden-xs">
    <div class="container">
        <ul class="nav navbar-nav">
            <li class="dropdown navbar-link-style-1 navbar-default-link-karta">
                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Красноярск <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="javascript:void(0)">Тобольск</a></li>
                    <li><a href="javascript:void(0)">Екатеринбург</a></li>
                </ul>
            </li>
            <li class="dropdown navbar-link-style-1">
                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Магазины <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="javascript:void(0)">на ул. Пермякова</a></li>
                    <li><a href="javascript:void(0)">на ул. Геологоразведчиков</a></li>
                </ul>
            </li>
            <?foreach($arResult['ITEMS'] as $arItem):?>
                <li><a href="<?=$arItem['LINK']?>"><?=$arItem['TEXT']?></a></li>
            <?endforeach?>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="navbar-link-style-1 navbar-default-link-vhod"><a href="javascript:void(0)">Вход</a></li>
        </ul>
    </div>
</nav>