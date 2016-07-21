<?
namespace Tools\Params;

class SearchForm extends Base
{
	public static function searchForm()
	{
		$array = Array(
			"COMPONENT_TEMPLATE" => ".default",
			"PAGE" => "#SITE_DIR#search/",
			"USE_SUGGEST" => "N"
		);
		return $array;
	}

	public static function top()
	{
		return Common::glue(array(
			self::searchForm(),
		));
	}

	public static function xs()
	{
		return Common::glue(array(
			self::searchForm(),
		));
	}

	public static function bottom()
	{
		return Common::glue(array(
			self::searchForm(),
		));
	}
}