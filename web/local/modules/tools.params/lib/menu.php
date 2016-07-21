<?
namespace Tools\Params;

class Menu extends Base
{
	private static function menuCache()
	{
		$cache = Common::cache();
		return array(
			"MENU_CACHE_TIME" => $cache['CACHE_TIME'],
			"MENU_CACHE_TYPE" => $cache['CACHE_TYPE'],
			"MENU_CACHE_USE_GROUPS" => $cache['CACHE_GROUPS'],
		);
	}

	public static function menu()
	{
		$array = Array(
			"MENU_CACHE_TIME" => "A",
			"MENU_CACHE_TYPE" => "25920",
			"MENU_CACHE_USE_GROUPS" => "N",
			"ALLOW_MULTI_SELECT" => "N",
			"CHILD_MENU_TYPE" => "left",
			"COMPONENT_TEMPLATE" => ".default",
			"DELAY" => "N",
			"MAX_LEVEL" => "4",
			"MENU_CACHE_GET_VARS" => array(""),
			"ROOT_MENU_TYPE" => "top",
			"USE_EXT" => "Y"
		);
		return Common::glue(array(
			$array,
			self::menuCache()
		));
	}

	public static function main()
	{
		return Common::glue(array(
			self::menu(),
			array(
				'ROOT_MENU_TYPE' => 'main',
				'MAX_LEVEL' => '1',
			)
		));
	}

	public static function mainXs()
	{
		return Common::glue(array(
			self::menu(),
			array(
				'ROOT_MENU_TYPE' => 'main',
				'MAX_LEVEL' => '1',
			)
		));
	}

	public static function topXs()
	{
		return Common::glue(array(
			self::menu(),
			array(
				'ROOT_MENU_TYPE' => 'top',
				'MAX_LEVEL' => '1',
			)
		));
	}

	public static function top()
	{
		return Common::glue(array(
			self::menu(),
			array(
				'ROOT_MENU_TYPE' => 'top',
				'MAX_LEVEL' => '1',
			)
		));
	}

	public static function bottom()
	{
		return Common::glue(array(
			self::menu(),
			array(
				'ROOT_MENU_TYPE' => 'bottom',
				'MAX_LEVEL' => '1',
			)
		));
	}
}