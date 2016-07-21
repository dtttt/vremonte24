<?
namespace Tools\Params;

class SaleBasketBasket extends Base
{
	public static function saleBasketBasket()
	{
		$av_catalog = catalog::avCatalog();
		$paths = Common::paths();
		$array = Array(
			"ACTION_VARIABLE" => "action",
			"COLUMNS_LIST" => array("NAME", "DISCOUNT", "WEIGHT", "DELETE", "DELAY", "TYPE", "PRICE", "QUANTITY"),
			"COMPONENT_TEMPLATE" => ".default",
			"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
			"HIDE_COUPON" => "N",
			"PATH_TO_ORDER" => "/personal/order.php",
			"PRICE_VAT_SHOW_VALUE" => "N",
			"QUANTITY_FLOAT" => "N",
			"SET_TITLE" => "Y",
			"USE_PREPAYMENT" => "N"
		);
		return Common::glue($array, array(
			array(
				'PATH_TO_ORDER' => $paths['PATH_TO_ORDER'],
				'SET_TITLE' => 'N',
				'PRICE_VAT_SHOW_VALUE' => $av_catalog['PRICE_VAT_SHOW_VALUE'],
				'CATALOG_URL' => $av_catalog['SEF_FOLDER'],
				'HIDE_COUPON' => 'Y',
				// array("NAME", "DISCOUNT", "WEIGHT", "PROPS", "DELETE", "DELAY", "TYPE", "PRICE", "QUANTITY", "SUM", "PROPERTY_CML2_ARTICLE", "PROPERTY_MORE_PHOTO", "PROPERTY_CML2_ATTRIBUTES"),
				'COLUMNS_LIST' => array('PROPERTY_CML2_ARTICLE', 'NAME', 'PROPS', 'TYPE', 'PRICE', 'QUANTITY', 'SUM', 'DELETE'),
				'ACTION_VARIABLE' => $av_catalog['ACTION_VARIABLE'],
			)
		));
	}
}