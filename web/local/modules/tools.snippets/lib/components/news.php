<?
namespace Tools\Snippets\Components;

// сниппеты для компонента bitrix:news.list, bitrix:news.detail
class News
{
	private function __construct() {}

	/**
	 * для правки значения свойства, используемого для ссылок url
	 * @param $arResult
	 * @param $arParams
	 * @param $propNames
	 * @param $deleteInvalidValues - удалять некорректные ссылки
	 * @param bool $propValuesForceArray - ['display_properties']['свойство']['display_value'] будет всегда массивом, для свойств с множ. знач.
	 */
	public static function fixPropLink(&$arResult, &$arParams, $propNames, $deleteInvalidValues = false, $propValuesForceArray = false)
	{
		// Подготовка
		$arItems = &\Tools\Snippets\Component::getItems($arResult);
		if (!is_array($propNames)) $propNames = Array((string)$propNames);

		// Итерация по элементам
		foreach ($arItems as &$arItem) {
			// По свойствам переданным параметров $propNames
			foreach($propNames as &$propName) {
				if (!array_key_exists($propName, $arItem['DISPLAY_PROPERTIES'])) continue;
				$arProp = &$arItem['DISPLAY_PROPERTIES'][$propName];
				// валидация типа свойства "строка"
				if ($arProp['PROPERTY_TYPE'] != 'S' || strlen($arProp['USER_TYPE'])) continue;
				if (!is_array($arProp['VALUE'])) $arProp['VALUE'] = Array($arProp['VALUE']);

				// правка ссылки
				foreach($arProp['VALUE'] as $key=>&$value) {
					$value = trim($value);

					// проверка
					if (!strlen($value) || preg_match('/^#+$/', $value) || preg_match('#^javascript\s*:\s*void#i', $value) || \CHTTP::isPathTraversalUri($value)) {
						if ($deleteInvalidValues) unset($arProp['VALUE'][$key]);
						else $value = 'javascript:void(0)';
						continue;
					}

					if (preg_match('#^([a-z]+:)?//#i', $value, $matches)) {
						if (!strlen($matches[1])) $value = 'http:'.$value;
					}
					elseif (preg_match('#^'.preg_quote(SITE_DIR).'#', $value)) {
						continue;
					}
					else
						$value = 'http://'.$value;
				}
				$arProp['DISPLAY_VALUE'] = $arProp['VALUE'];

				if ($arProp['MULTIPLE'] != 'Y' && !$propValuesForceArray)
					$arProp['DISPLAY_VALUE'] = reset($arProp['DISPLAY_VALUE']);

			}
		}

	}

	/**
	 * для получения информации по инфоблоку
	 * @param $arResult
	 * @param $arParams
	 */
	public static function iblock(&$arResult, &$arParams, &$obj, $resultKey = 'IBLOCK')
	{
		// проверка
		if (!is_numeric($arParams['IBLOCK_ID'])) return;
		if (!\CModule::IncludeModule('iblock')) return;

		$cache_part = $arParams['IBLOCK_ID'];
		$cache = new \Tools\Snippets\Cache($arParams['CACHE_TIME'], $obj->__component->GetName()."|".$obj->__component->GetTemplatePage()."|".$cache_part."|".__NAMESPACE__."|".__CLASS__."|".__FUNCTION__);
		if (!$cache->get() && \CModule::IncludeModule('iblock'))
		{
			if ($arIBlock = \CIBlock::GetById($arParams['IBLOCK_ID'])->GetNext(true,false))
			{
				$arIBlock["IBLOCK_CODE"] = $arIBlock["CODE"];
				$arIBlock["LIST_PAGE_URL"] = \CIBlock::ReplaceDetailURL($arIBlock["LIST_PAGE_URL"], $arIBlock, true, false);

				$cache->vars['IBLOCK'] = $arIBlock;
				$cache->set('iblock_id_'.$arIBlock['ID']);
			}
		}
		$arResult[$resultKey] = $cache->vars['IBLOCK'];
	}

	/**
	 * получает раздел элемента
	 * @param $ElementID
	 * @param $arResult
	 * @param $arParams
	 * @param $obj
	 */
	public static function detailBack($ElementID, &$arResult, &$arParams, &$component)
	{
		if (!is_numeric($ElementID)) return;

		$cache = new \Tools\Snippets\Cache($arParams['CACHE_TIME'], $component->GetName()."|".$component->GetTemplatePage()."|".$ElementID."|".basename(__FILE__));
		if (!$cache->get() && \CModule::IncludeModule('iblock')) {

			$rsElement = \CIBlockElement::GetList(Array(), Array('ID' => $ElementID), false, false, Array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'LIST_PAGE_URL', 'SECTION_PAGE_URL', 'DETAIL_PAGE_URL'));
			$rsElement->SetUrlTemplates("", $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"], $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"]);

			if ($arElement = $rsElement->GetNext(true, false)) {
				$cache->vars['ELEMENT'] = $arElement;
			}

			$cache->set('iblock_id_' . $arParams['IBLOCK_ID']);

		}

		return $cache->vars;
	}
}