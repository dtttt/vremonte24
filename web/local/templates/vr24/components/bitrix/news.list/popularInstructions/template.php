<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult['ITEMS'])):?>
    <h3>Популярные инструкции для устройства</h3>
    <div class="grid">
        <div class="row">
            <?$i = 0?>
            <?foreach($arResult['ITEMS'] as $arItem):?>
                <?if (++$i > 2):?>
                    <div class="col col-xs-6 col-sm-3">
                        <div class="item">
                            <div class="img">
                                <?if ($arItem['PICTURE']['THUMB']):?>
                                    <img src="<?=$arItem['PICTURE']['THUMB']['src']?>" alt="<?=$arItem['PICTURE']['ALT']?>" title="<?=$arItem['PICTURE']['TITLE']?>'" class="img-responsive">
                                <?else:?>
                                    <img src="http://dummyimage.com/160x160.jpg" alt="<?=$arItem['NAME']?>" title="<?=$arItem['NAME']?>" class="img-responsive">
                                <?endif?>
                            </div>
                            <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="title text-info">
                                <?=$arItem['NAME']?>
                            </a>
                            <div class="stats">
                                <div class="views"></div>
                                <div class="comments"></div>
                            </div>
                        </div>
                    </div>
                <?else:?>
                    <div class="col col-xs-12 col-sm-6">
                        <div class="item">
                            <div class="img">
                                <img src="http://dummyimage.com/344x192.jpg" class="img-responsive">
                            </div>
                            <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="title text-info">
                                <?=$arItem['NAME']?>
                            </a>
                            <div class="stats">
                                <div class="views"></div>
                                <div class="comments"></div>
                            </div>
                        </div>
                    </div>
                <?endif?>
            <?endforeach?>
        </div>
    </div>
<?endif?>