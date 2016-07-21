<?
namespace Tools\Params;

class SaleBasketBasketLine extends Base
{
    public static function saleBasketBasketLine() {
        $paths = Common::paths();
        $array = Array(
            "HIDE_ON_BASKET_PAGES" => "Y",
            "PATH_TO_BASKET" => SITE_DIR."personal/cart/",
            "PATH_TO_ORDER" => SITE_DIR."personal/order/make/",
            "PATH_TO_PERSONAL" => SITE_DIR."personal/",
            "PATH_TO_PROFILE" => SITE_DIR."personal/",
            "PATH_TO_REGISTER" => SITE_DIR."login/",
            "POSITION_FIXED" => "N",
            "POSITION_HORIZONTAL" => "right",
            "POSITION_VERTICAL" => "top",
            "SHOW_AUTHOR" => "N",
            "SHOW_DELAY" => "N",
            "SHOW_EMPTY_VALUES" => "Y",
            "SHOW_IMAGE" => "Y",
            "SHOW_NOTAVAIL" => "N",
            "SHOW_NUM_PRODUCTS" => "Y",
            "SHOW_PERSONAL_LINK" => "N",
            "SHOW_PRICE" => "Y",
            "SHOW_PRODUCTS" => "Y",
            "SHOW_SUBSCRIBE" => "N",
            "SHOW_SUMMARY" => "Y",
            "SHOW_TOTAL_PRICE" => "Y"
        );
        return Common::glue(array(
            $array,
            array(
                "HIDE_ON_BASKET_PAGES" => "N",
                "PATH_TO_BASKET" => $paths['PATH_TO_BASKET'],
                "PATH_TO_ORDER" => $paths['PATH_TO_ORDER'],
                "PATH_TO_PERSONAL" => $paths['PATH_TO_PERSONAL'],
                "PATH_TO_PROFILE" => $paths['PATH_TO_PROFILE'],
                "PATH_TO_REGISTER" => $paths['PATH_TO_REGISTER'],
            )
        ));
    }

    public static function saleBasketBasketLineNotXs() {
        return Common::glue(array(
            self::saleBasketBasketLine(),
            array(
                "SHOW_EMPTY_VALUES" => "N",
                "SHOW_IMAGE" => "N",
                "SHOW_PRICE" => "N",
                "SHOW_PRODUCTS" => "Y",
                "SHOW_SUMMARY" => "N",
                "SHOW_TOTAL_PRICE" => "N",
            )
        ));
    }

    public static function saleBasketBasketLineXs() {
        return Common::glue(array(
            self::saleBasketBasketLine(),
        ));
    }

    public static function saleBasketBasketLineXsMenu() {
        return Common::glue(array(
            self::saleBasketBasketLine(),
            array(
                "SHOW_EMPTY_VALUES" => "N",
                "SHOW_IMAGE" => "N",
                "SHOW_PRICE" => "N",
                "SHOW_PRODUCTS" => "Y",
                "SHOW_SUMMARY" => "N",
                "SHOW_TOTAL_PRICE" => "N",
            )
        ));
    }
}