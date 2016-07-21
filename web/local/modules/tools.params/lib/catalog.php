<?
namespace Tools\Params;

class Catalog extends Base
{
	private static function paths()
	{
		$paths = Common::paths();
		$array = array(
			'BASKET_URL' => $paths['PATH_TO_BASKET'],
		);
		return $array;
	}

	public static function catalog()
	{
		$array = Array(
			"ACTION_VARIABLE" => "action",
			"ADD_ELEMENT_CHAIN" => "N",
			"ADD_PROPERTIES_TO_BASKET" => "Y",
			"ADD_SECTIONS_CHAIN" => "Y",
			"AJAX_MODE" => "N",
			"AJAX_OPTION_ADDITIONAL" => "",
			"AJAX_OPTION_HISTORY" => "N",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "Y",
			"ALSO_BUY_ELEMENT_COUNT" => "5",
			"ALSO_BUY_MIN_BUYES" => "1",
			"BASKET_URL" => "/personal/basket.php",
			"CACHE_FILTER" => "N",
			"CACHE_GROUPS" => "Y",
			"CACHE_TIME" => "36000000",
			"CACHE_TYPE" => "A",
			"COMPARE_ELEMENT_SORT_FIELD" => "sort",
			"COMPARE_ELEMENT_SORT_ORDER" => "asc",
			"COMPARE_FIELD_CODE" => array("", ""),
			"COMPARE_NAME" => "CATALOG_COMPARE_LIST",
			"COMPARE_PROPERTY_CODE" => array("", ""),
			"COMPONENT_TEMPLATE" => ".default",
			"CONVERT_CURRENCY" => "N",
			"DETAIL_BACKGROUND_IMAGE" => "-",
			"DETAIL_BROWSER_TITLE" => "-",
			"DETAIL_CHECK_SECTION_ID_VARIABLE" => "N",
			"DETAIL_META_DESCRIPTION" => "-",
			"DETAIL_META_KEYWORDS" => "-",
			"DETAIL_PROPERTY_CODE" => array("", ""),
			"DETAIL_SET_CANONICAL_URL" => "N",
			"DETAIL_SET_VIEWED_IN_COMPONENT" => "N",
			"DISABLE_INIT_JS_IN_COMPONENT" => "Y",
			"DISPLAY_BOTTOM_PAGER" => "Y",
			"DISPLAY_ELEMENT_SELECT_BOX" => "N",
			"DISPLAY_TOP_PAGER" => "N",
			"ELEMENT_SORT_FIELD" => "sort",
			"ELEMENT_SORT_FIELD2" => "id",
			"ELEMENT_SORT_ORDER" => "asc",
			"ELEMENT_SORT_ORDER2" => "desc",
			"FIELDS" => array("", ""),
			"HIDE_NOT_AVAILABLE" => "N",
			"IBLOCK_ID" => "",
			"IBLOCK_TYPE" => "",
			"INCLUDE_SUBSECTIONS" => "Y",
			"LINE_ELEMENT_COUNT" => "3",
			"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
			"LINK_IBLOCK_ID" => "",
			"LINK_IBLOCK_TYPE" => "",
			"LINK_PROPERTY_SID" => "",
			"LIST_BROWSER_TITLE" => "-",
			"LIST_META_DESCRIPTION" => "-",
			"LIST_META_KEYWORDS" => "-",
			"LIST_PROPERTY_CODE" => array("", ""),
			"MAIN_TITLE" => "Наличие на складах",
			"MESSAGE_404" => "",
			"MIN_AMOUNT" => "10",
			"PAGER_BASE_LINK_ENABLE" => "N",
			"PAGER_DESC_NUMBERING" => "N",
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
			"PAGER_SHOW_ALL" => "N",
			"PAGER_SHOW_ALWAYS" => "N",
			"PAGER_TEMPLATE" => ".default",
			"PAGER_TITLE" => "Товары",
			"PAGE_ELEMENT_COUNT" => "30",
			"PARTIAL_PRODUCT_PROPERTIES" => "N",
			"PRICE_CODE" => array(),
			"PRICE_VAT_INCLUDE" => "Y",
			"PRICE_VAT_SHOW_VALUE" => "N",
			"PRODUCT_ID_VARIABLE" => "id",
			"PRODUCT_PROPERTIES" => array(),
			"PRODUCT_PROPS_VARIABLE" => "prop",
			"PRODUCT_QUANTITY_VARIABLE" => "",
			"SECTION_BACKGROUND_IMAGE" => "-",
			"SECTION_COUNT_ELEMENTS" => "Y",
			"SECTION_ID_VARIABLE" => "SECTION_ID",
			"SECTION_TOP_DEPTH" => "2",
			"SEF_FOLDER" => "/",
			"SEF_MODE" => "Y",
			"SEF_URL_TEMPLATES" => Array(
				"compare" => "compare.php?action=#ACTION_CODE#",
				"element" => "#SECTION_ID#/#ELEMENT_ID#/",
				"section" => "#SECTION_ID#/",
				"sections" => "",
				"smart_filter" => "#SECTION_ID#/filter/#SMART_FILTER_PATH#/apply/"
			),
			"SET_LAST_MODIFIED" => "N",
			"SET_STATUS_404" => "N",
			"SET_TITLE" => "Y",
			"SHOW_404" => "N",
			"SHOW_DEACTIVATED" => "N",
			"SHOW_EMPTY_STORE" => "Y",
			"SHOW_GENERAL_STORE_INFORMATION" => "N",
			"SHOW_PRICE_COUNT" => "1",
			"SHOW_TOP_ELEMENTS" => "N",
			"STORES" => array(),
			"STORE_PATH" => "/store/#store_id#",
			"TOP_ELEMENT_COUNT" => "9",
			"TOP_ELEMENT_SORT_FIELD" => "sort",
			"TOP_ELEMENT_SORT_FIELD2" => "id",
			"TOP_ELEMENT_SORT_ORDER" => "asc",
			"TOP_ELEMENT_SORT_ORDER2" => "desc",
			"TOP_LINE_ELEMENT_COUNT" => "3",
			"TOP_PROPERTY_CODE" => array("", ""),
			"USER_FIELDS" => array("", ""),
			"USE_ALSO_BUY" => "N",
			"USE_COMPARE" => "N",
			"USE_ELEMENT_COUNTER" => "N",
			"USE_FILTER" => "N",
			"USE_MAIN_ELEMENT_SECTION" => "N",
			"USE_MIN_AMOUNT" => "N",
			"USE_PRICE_COUNT" => "N",
			"USE_PRODUCT_QUANTITY" => "N",
			"USE_STORE" => "N",
			"VARIABLE_ALIASES" => Array(
				"ELEMENT_ID" => "ELEMENT_ID",
				"SECTION_ID" => "SECTION_ID"
			)
		);
		return Common::glue(array(
			$array,
			SystemPagenavigation::systemPagenavigation(),
			Common::cache(),
			Common::disableAjax(),
			Common::show404(),
			self::paths(),
			array(
				'PAGER_SHOW_ALL' => 'Y',
			)
		));
	}

	public static function vr24()
	{
		$array = array(
			"DETAIL_FIELD_CODE" => array("DETAIL_PICTURE", "PREVIEW_PICTURE", "DETAIL_TEXT", "DETAIL_TEXT_TYPE", "PREVIEW_TEXT", "PREVIEW_TEXT_TYPE"),
			"DETAIL_PROPERTY_CODE" => array("MORE_PHOTO", "CML2_ATTRIBUTES", "CML2_ARTICLE", "CML2_MANUFACTURER", "PLUSES", "VIDEO"),

			"IBLOCK_ID" => "2",
			"IBLOCK_TYPE" => "1c_catalog",

			"LIST_FIELD_CODE" => array("PREVIEW_PICTURE", "DETAIL_PICTURE", "NAME"),
			"LIST_PROPERTY_CODE" => array("LABEL"),

			"PAGE_ELEMENT_COUNT" => "1",
			"PRICE_CODE" => Array("Базовая"),

			"SECTION_FIELDS" => array(),
			"SECTION_USER_FIELDS" => array(),
			"SECTION_COUNT_ELEMENTS" => "N",
			"SECTION_TOP_DEPTH" => "999999",
			"SECTIONS_ADD_CHAIN" => "N",

			"SEF_FOLDER" => "/catalog/",
			"SEF_URL_TEMPLATES" => Array(
				"compare" => "",
				"element" => "item/#ELEMENT_ID#/",
				"section" => "#SECTION_ID#/",
				"sections" => "",
				"smart_filter" => "#SECTION_ID#/filter/#SMART_FILTER_PATH#/",
				//"smart_filter_iblock" => "#SMART_FILTER_PATH#/",
			),
			"FILTER_NAME" => "arrCatalogFilter",
			"TOP_FILTER_HAVE_SELECTED_NAME" => "catalogFilterHaveSelected",
			"USE_FILTER" => "Y",
			"FILTER_SEF_MODE" => "N",

			"SHOW_ALL_WO_SECTION" => "Y",

			"TOP_SECTION_TOP_DEPTH" => "1",
			"TOP_SECTION_FIELDS" => array("ID", "NAME", "PICTURE"),
			"TOP_SECTION_USER_FIELDS" => array(),

			"USE_PRODUCT_QUANTITY" => "Y",
			//"OFFERS_IBLOCK_ID" => "3",
            "REVIEWS" => \Tools\Params\NewsList::reviews(),
            "QUESTIONS" => \Tools\Params\NewsList::questions(),
            "PARTS" => \Tools\Params\CatalogSection::parts(),
            "POPULAR_INSTRUCTIONS" => \Tools\Params\NewsList::popularInstructions(),
            "POPULAR_QUESTIONS" => \Tools\Params\NewsList::popularQuestions(),
		);

		$array = Common::glue(array(
			$array
		), array(
			self::catalog()
		));
		return $array;
	}
}