<?
namespace Tools\Params;

class SystemPagenavigation extends \Tools\Params\Base
{
	public static function systemPagenavigation()
	{
		$cache = Common::cache();
		$array = array(
			'DISPLAY_TOP_PAGER' => 'N',
			'DISPLAY_BOTTOM_PAGER' => 'Y',
			'PAGER_TITLE' => '',
			'PAGER_SHOW_ALWAYS' => 'N',
			'PAGER_TEMPLATE' => '.default',
			'PAGER_DESC_NUMBERING' => 'N',
			'PAGER_DESC_NUMBERING_CACHE_TIME' => '86400',
			'PAGER_SHOW_ALL' => 'N',
			'PAGER_BASE_LINK_ENABLE' => 'Y',
			'PAGER_BASE_LINK' => '',
			'PAGER_PARAMS_NAME' => 'arrPager'
		);
		return Common::glue($array, array(
			Common::cache(),
			array('PAGER_DESC_NUMBERING_CACHE_TIME' => $cache['CACHE_TIME'])
		));
	}
	
	public static function disableSystemPagenavigation()
	{
		return Common::glue(array(
			'DISPLAY_TOP_PAGER' => 'N',
			'DISPLAY_BOTTOM_PAGER' => 'N',
		), null, Array(
			self::systemPagenavigation()
		));
	}
	
	public static function complexSystemPagenavigation()
	{
		$systemPagenavigation = self::systemPagenavigation();
		$array = array(
			"DETAIL_DISPLAY_BOTTOM_PAGER" => $systemPagenavigation['DISPLAY_BOTTOM_PAGER'],
			"DETAIL_DISPLAY_TOP_PAGER" => $systemPagenavigation['DISPLAY_TOP_PAGER'],
			"DETAIL_PAGER_SHOW_ALL" => $systemPagenavigation['PAGER_SHOW_ALL'],
			"DETAIL_PAGER_TEMPLATE" => $systemPagenavigation['PAGER_TEMPLATE'],
			"DETAIL_PAGER_TITLE" => $systemPagenavigation['PAGER_TITLE'],
		);
		return Common::glue($array, array($systemPagenavigation));
	}
}