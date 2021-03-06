<?
namespace Tools\Params;

class SaleOrderAjax extends Base
{
	public static function saleOrderAjax()
	{
		$paths = Common::paths();
		$array = Array(
			"ALLOW_AUTO_REGISTER" => "N",
			"ALLOW_NEW_PROFILE" => "Y",
			"COMPONENT_TEMPLATE" => ".default",
			"COUNT_DELIVERY_TAX" => "N",
			"DELIVERY_NO_AJAX" => "N",
			"DELIVERY_NO_SESSION" => "N",
			"DELIVERY_TO_PAYSYSTEM" => "d2p",
			"DISABLE_BASKET_REDIRECT" => "N",
			"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
			"PATH_TO_AUTH" => "/auth/",
			"PATH_TO_BASKET" => "basket.php",
			"PATH_TO_PAYMENT" => "payment.php",
			"PATH_TO_PERSONAL" => "index.php",
			"PAY_FROM_ACCOUNT" => "Y",
			"PRODUCT_COLUMNS" => array(),
			"SEND_NEW_USER_NOTIFY" => "Y",
			"SET_TITLE" => "Y",
			"SHOW_PAYMENT_SERVICES_NAMES" => "Y",
			"SHOW_STORES_IMAGES" => "N",
			"TEMPLATE_LOCATION" => ".default",
			"USE_PREPAYMENT" => "N"
		);
		return Common::glue($array, array(
			Common::paths(),
			array(
				'ALLOW_AUTO_REGISTER' => 'Y',
			)
		));
	}
}