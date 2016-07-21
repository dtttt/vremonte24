<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<div style="margin: 0 0 27px 0;" class="hidden-xs">
    <form action="<?=$arResult["FORM_ACTION"]?>" method="GET">
        <div class="input-group">
            <div class="input-site-search-container">
                <input type="text" class="form-control" name="q" value="" placeholder="Поиск по сайту">
                <div class="dropdown input-site-search-category small">
                    <a href="javascript:void(0)" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Категория <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="javascript:void(0)">Аккумуляторы</a></li>
                        <li><a href="javascript:void(0)">Дисплеи и Тачскрины</a></li>
                    </ul>
                </div>
            </div>
            <span class="input-group-btn">
                <input type="submit" class="btn btn-info" value="Найти">
            </span>
        </div>
    </form>
</div>