<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<!DOCTYPE HTML>
<html lang="<?=LANGUAGE_ID?>">
<head>
    <?
    $a = Bitrix\Main\Page\Asset::getInstance();
    $a->addString('<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">');
    $a->addString('<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">');
    $a->addString('<meta name="author" content="crtweb.ru">');
    $a->addCss(SITE_TEMPLATE_PATH . '/lib/bootstrap/css/bootstrap.css');
    $a->addCss(SITE_TEMPLATE_PATH . '/lib/fancybox/source/jquery.fancybox.css');
    $a->addCss(SITE_TEMPLATE_PATH . '//fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300&subset=latin,cyrillic');
    $a->addCss(SITE_TEMPLATE_PATH . '/lib/owl-carousel/owl.carousel.css');
    $a->addJs('//code.jquery.com/jquery-3.0.0.min.js');
    $a->addJs(SITE_TEMPLATE_PATH . '/lib/fancybox/source/jquery.fancybox.pack.js');
    $a->addJs(SITE_TEMPLATE_PATH . '/lib/bootstrap/js/bootstrap.min.js');
    $a->addJs(SITE_TEMPLATE_PATH . '/lib/owl-carousel/owl.carousel.min.js');
    $a->addJs(SITE_TEMPLATE_PATH . '/lib/tinycarousel/jquery.tinycarousel.min.js');
    $a->addJs(SITE_TEMPLATE_PATH . '/js/script.js');
    unset($a);
    $APPLICATION->ShowHead();?>
    <title><?$APPLICATION->ShowTitle();?></title>
</head>
<body>
    <?if($GLOBALS['USER']->IsAuthorized() && $GLOBALS['USER']->IsAdmin()) { echo '<div>'; $APPLICATION->ShowPanel(); echo '</div>'; }?>
    <div class="visible-xs xs-top">
        <div class="container-fluid">
            <div class="row ">
                <a href="javascript:void(0)" class="col-xs-2 xs-col xs-btn xs-menu-btn">
                    <div class="xs-top-icon xs-menu-icon"></div>
                </a>
                <a href="<?=SITE_DIR?>" class="col-xs-4 xs-col xs-logo-notbtn">
                    <div class="xs-top-icon xs-site-logo"></div>
                </a>
                <a href="javascript:void(0)" class="col-xs-2 xs-col xs-btn xs-search-btn">
                    <div class="xs-top-icon xs-search-icon"></div>
                </a>
                <a href="javascript:void(0)" class="col-xs-2 xs-col xs-btn xs-login-btn">
                    <div class="xs-top-icon xs-login-icon"></div>
                </a>
                <?$GLOBALS['APPLICATION']->IncludeComponent(
                    "bitrix:sale.basket.basket.line",
                    "xsMenu",
                    Tools\Params\SaleBasketBasketLine::saleBasketBasketLineXsMenu()
                );?>
            </div>
        </div>
        <div class="xs-menu-block xs-block">
            <?$GLOBALS['APPLICATION']->IncludeComponent(
                "bitrix:menu",
                "mainXs",
                Tools\Params\Menu::mainXs()
            );?>
            <?$GLOBALS['APPLICATION']->IncludeComponent(
                "bitrix:menu",
                "topXs",
                Tools\Params\Menu::topXs()
            );?>
        </div>
        <?$GLOBALS['APPLICATION']->IncludeComponent(
            "bitrix:search.form",
            "xs",
            Tools\Params\SearchForm::xs()
        );?>
        <?$GLOBALS['APPLICATION']->IncludeComponent(
            "bitrix:sale.basket.basket.line",
            "xs",
            Tools\Params\SaleBasketBasketLine::saleBasketBasketLineXs()
        );?>
    </div>

    <?$GLOBALS['APPLICATION']->IncludeComponent(
        "bitrix:menu",
        "top",
        Tools\Params\Menu::top()
    );?>

    <header class="container hidden-xs">
        <div class="row">
            <div class="col-xs-6 col-sm-3">
                <a href="<?=SITE_DIR?>" class="site-logo"></a>
            </div>
            <div class="col-xs-12 col-sm-5">
                <?$GLOBALS['APPLICATION']->IncludeComponent(
                    "bitrix:search.form",
                    "top",
                    Tools\Params\SearchForm::top()
                );?>
            </div>
            <div class="col-xs-6 col-sm-2">
                <div class="text-right telephone">
                    <span class="text-nowrap country-city">
                        <?$APPLICATION->IncludeFile('/includes/siteHeaderTelephoneCountryCity.php')?>
                    </span>
                    <span class="text-nowrap local">
                        <?$APPLICATION->IncludeFile('/includes/siteHeaderTelephoneLocal.php')?>
                    </span>
                </div>
                <div class="text-right">
                    <a href="javascript:void(0)" class="perezvonite-mne dotted-gray">
                        Перезвоните мне
                    </a>
                </div>
            </div>
            <div class="col-xs-6 col-sm-2">
                <?$GLOBALS['APPLICATION']->IncludeComponent(
                    "bitrix:sale.basket.basket.line",
                    "notXs",
                    Tools\Params\SaleBasketBasketLine::saleBasketBasketLineNotXs()
                );?>
            </div>
        </div>
    </header>

    <?$GLOBALS['APPLICATION']->IncludeComponent(
        "bitrix:menu",
        "main",
        Tools\Params\Menu::main()
    );?>

<section class="container">
    <div class="row">
        <div class="col-xs-12">
            <?$GLOBALS['APPLICATION']->IncludeComponent(
                "bitrix:breadcrumb",
                "",
                Tools\Params\Breadcrumb::breadcrumb()
            );?>
            <article>
                <div class="row">
                    <div class="col-xs-12">