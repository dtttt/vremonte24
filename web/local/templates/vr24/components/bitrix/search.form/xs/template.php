<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<div class="xs-search-block xs-block">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <form action="<?=$arResult["FORM_ACTION"]?>" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control input-sm" name="q" value="" placeholder="Поиск по сайту">
                        <span class="input-group-btn">
                            <input type="submit" class="btn btn-sm btn-primary" value="Найти">
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>