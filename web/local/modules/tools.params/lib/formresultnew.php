<?
namespace Tools\Params;

class FormResultNew extends Base
{
	private static function formResultNewDefault()
	{
		return array(
			'SEF_MODE' => 'N',
			'LIST_URL' => '',
			'EDIT_URL' => '',
			'SUCCESS_URL' => '',
			'CHAIN_ITEM_TEXT' => '',
			'CHAIN_ITEM_LINK' => '',
			'IGNORE_CUSTOM_TEMPLATE' => 'N',
			'USE_EXTENDED_ERRORS' => 'Y',
			'VARIABLE_ALIASES' => Array(
				'WEB_FORM_ID' => 'WEB_FORM_ID',
				'RESULT_ID' => 'RESULT_ID'
			),
		);
	}

	public static function formResultNew()
	{
		$array = Array(
			"CACHE_TIME" => "3600",
			"CACHE_TYPE" => "A",
			"CHAIN_ITEM_LINK" => "",
			"CHAIN_ITEM_TEXT" => "",
			"COMPONENT_TEMPLATE" => ".default",
			"EDIT_URL" => "result_edit.php",
			"IGNORE_CUSTOM_TEMPLATE" => "N",
			"LIST_URL" => "result_list.php",
			"SEF_MODE" => "N",
			"SUCCESS_URL" => "",
			"USE_EXTENDED_ERRORS" => "N",
			"VARIABLE_ALIASES" => Array(
				"RESULT_ID" => "RESULT_ID",
				"WEB_FORM_ID" => "WEB_FORM_ID"
			),
			"WEB_FORM_ID" => "",
		);
		return Common::glue($array, array(
			self::formResultNewDefault(),
			Common::disableAjax(),
			Common::cache()
		));
	}
}