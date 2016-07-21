<?
namespace Tools\Params;

class SalePersonalOrder extends Base
{
	public static function salePersonalOrder()
	{
		$paths = Common::paths();
		$array = Array(
			"ACTIVE_DATE_FORMAT" => "d.m.Y",
			"CACHE_GROUPS" => "Y",
			"CACHE_TIME" => "3600",
			"CACHE_TYPE" => "A",
			"COMPONENT_TEMPLATE" => ".default",
			"CUSTOM_SELECT_PROPS" => array(""),
			"HISTORIC_STATUSES" => array("F"),
			"NAV_TEMPLATE" => "",
			"ORDERS_PER_PAGE" => "20",
			"PATH_TO_BASKET" => "basket.php",
			"PATH_TO_PAYMENT" => "payment.php",
			"SAVE_IN_SESSION" => "Y",
			"SEF_FOLDER" => "/",
			"SEF_MODE" => "Y",
			"SEF_URL_TEMPLATES" => Array(
				"cancel" => "order_cancel.php?ID=#ID#",
				"detail" => "order_detail.php?ID=#ID#",
				"list" => "index.php"
			),
			"SET_TITLE" => "Y",
			"STATUS_COLOR_F" => "gray",
			"STATUS_COLOR_N" => "green",
			"STATUS_COLOR_PSEUDO_CANCELLED" => "red"
		);
		return Common::glue($array, array(
			Common::cache(),
			array(
				'PATH_TO_BASKET' => $paths['PATH_TO_BASKET'],
				'PATH_TO_PAYMENT' => $paths['PATH_TO_PAYMENT'],
				'SEF_FOLDER' => '/history/',
				'SEF_URL_TEMPLATES' => array(
					'cancel' => '#ID#/cancel/',
					'detail' => '#ID#/',
					'list' => '',
				),
			)
		));
	}
}