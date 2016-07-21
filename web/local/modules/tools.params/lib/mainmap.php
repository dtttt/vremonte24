<?
namespace Tools\Params;

class MainMap extends Base
{
	public static function mainMap()
	{
		$array = Array(
			"CACHE_TIME" => "3600",
			"CACHE_TYPE" => "A",
			"COL_NUM" => "1",
			"COMPONENT_TEMPLATE" => ".default",
			"LEVEL" => "3",
			"SET_TITLE" => "N",
			"SHOW_DESCRIPTION" => "N"
		);

		return Common::glue($array, array(
			Common::cache(),
			array('CACHE_TIME' => "86400")
		));
	}
}