<?
namespace Tools\Params;

class News extends Base
{
	public static function news()
	{
		$array = Array(
			"ADD_ELEMENT_CHAIN" => "Y",
			"ADD_SECTIONS_CHAIN" => "Y",
			"AJAX_MODE" => "N",
			"AJAX_OPTION_ADDITIONAL" => "",
			"AJAX_OPTION_HISTORY" => "N",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "Y",
			"BROWSER_TITLE" => "-",
			"CACHE_FILTER" => "N",
			"CACHE_GROUPS" => "Y",
			"CACHE_TIME" => "36000000",
			"CACHE_TYPE" => "A",
			"CATEGORY_CODE" => "CATEGORY",
			"CATEGORY_IBLOCK" => array(),
			"CATEGORY_ITEMS_COUNT" => "5",
			"CHECK_DATES" => "Y",
			"COMPONENT_TEMPLATE" => ".default",
			"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
			"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
			"DETAIL_DISPLAY_TOP_PAGER" => "N",
			"DETAIL_FIELD_CODE" => array("", ""),
			"DETAIL_PAGER_SHOW_ALL" => "Y",
			"DETAIL_PAGER_TEMPLATE" => "",
			"DETAIL_PAGER_TITLE" => "Страница",
			"DETAIL_PROPERTY_CODE" => array("", ""),
			"DETAIL_SET_CANONICAL_URL" => "N",
			"DISPLAY_AS_RATING" => "rating",
			"DISPLAY_BOTTOM_PAGER" => "Y",
			"DISPLAY_DATE" => "Y",
			"DISPLAY_NAME" => "Y",
			"DISPLAY_PICTURE" => "Y",
			"DISPLAY_PREVIEW_TEXT" => "Y",
			"DISPLAY_TOP_PAGER" => "N",
			"FILTER_FIELD_CODE" => array("", ""),
			"FILTER_NAME" => "",
			"FILTER_PROPERTY_CODE" => array("", ""),
			"HIDE_LINK_WHEN_NO_DETAIL" => "N",
			"IBLOCK_ID" => "",
			"IBLOCK_TYPE" => "",
			"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
			"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
			"LIST_FIELD_CODE" => array("", ""),
			"LIST_PROPERTY_CODE" => array("", ""),
			"MAX_VOTE" => "5",
			"MESSAGE_404" => "",
			"META_DESCRIPTION" => "-",
			"META_KEYWORDS" => "-",
			"NEWS_COUNT" => "20",
			"NUM_DAYS" => "30",
			"NUM_NEWS" => "20",
			"PAGER_BASE_LINK_ENABLE" => "N",
			"PAGER_DESC_NUMBERING" => "N",
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
			"PAGER_SHOW_ALL" => "N",
			"PAGER_SHOW_ALWAYS" => "N",
			"PAGER_TEMPLATE" => ".default",
			"PAGER_TITLE" => "Новости",
			"PREVIEW_TRUNCATE_LEN" => "",
			"SEF_FOLDER" => "/",
			"SEF_MODE" => "Y",
			"SEF_URL_TEMPLATES" => Array(
				"detail" => "#ELEMENT_ID#/",
				"news" => "",
				"rss" => "rss/",
				"rss_section" => "#SECTION_ID#/rss/",
				"search" => "search/",
				"section" => ""
			),
			"SET_LAST_MODIFIED" => "N",
			"SET_STATUS_404" => "N",
			"SET_TITLE" => "Y",
			"SHOW_404" => "N",
			"SORT_BY1" => "ACTIVE_FROM",
			"SORT_BY2" => "SORT",
			"SORT_ORDER1" => "DESC",
			"SORT_ORDER2" => "ASC",
			"USE_CATEGORIES" => "N",
			"USE_FILTER" => "N",
			"USE_PERMISSIONS" => "N",
			"USE_RATING" => "N",
			"USE_RSS" => "N",
			"USE_SEARCH" => "N",
			"USE_SHARE" => "N",
			"VOTE_NAMES" => array("1", "2", "3", "4", "5", ""),
			"YANDEX" => "N"
		);
		return Common::glue($array, array(
			Common::cache(),
			systemPagenavigation::complexSystemPagenavigation(),
			Common::disableAjax(),
			Common::show404()
		));
	}

	public static function avNews()
	{
		return Common::glue(null, array(
			self::news(),
			array(
				"IBLOCK_ID" => "2",
				"IBLOCK_TYPE" => "type2",

				"NEWS_COUNT" => "5",
				"LIST_ACTIVE_DATE_FORMAT" => "j F, Y",
				"DETAIL_ACTIVE_DATE_FORMAT" => "j F, Y",
				"LIST_FIELD_CODE" => array("NAME", "PREVIEW_PICTURE", "DETAIL_PICTURE", "PREVIEW_TEXT", "PREVIEW_TEXT_TYPE", "DETAIL_TEXT", "DETAIL_TEXT_TYPE", "DATE_ACTIVE_FROM"),
				"DETAIL_FIELD_CODE" => array("NAME", "PREVIEW_PICTURE", "DETAIL_PICTURE", "PREVIEW_TEXT", "PREVIEW_TEXT_TYPE", "DETAIL_TEXT", "DETAIL_TEXT_TYPE", "DATE_ACTIVE_FROM"),

				"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
				"SEF_FOLDER" => "/news/",
				"SEF_URL_TEMPLATES" => Array(
					"detail" => "#ELEMENT_ID#/",
					"news" => "",
					"rss" => "",
					"rss_section" => "",
					"search" => "",
					"section" => ""
				),
			)
		));
	}
}