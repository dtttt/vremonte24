<?
namespace Tools\Snippets\Components;

// сниппеты для компонента bitrix:catalog.section.list
class CatalogSectionList
{
	private function __construct() {}
	// TODO: перевести функции для доработок в разных компонентах в подобие mvc. Добавить вывод стандартных шаблонов, наподобие модуля drupal views.
	/**
	 * для определения текущего раздела
	 * @param $arResult
	 * @param $arParams
	 * @param array $arParamSelectors
	 */
	public static function sectionsSelected(&$arResult, &$arParams, $arParamSelectors = array('SECTION_CODE_ACTIVE' => 'CODE', 'SECTION_ID_ACTIVE' => 'ID'), $ascendant = false)
	{
		$needle_key = null;
		$haystack_key = null;

		$arParamSelectors = !is_array($arParamSelectors) ? array() : $arParamSelectors;
		$arParamSelectors += array(
			'SECTION_CODE_ACTIVE' => 'CODE',
			'SECTION_ID_ACTIVE' => 'ID',
		);
		foreach ($arParamSelectors as $paramName => &$fieldCode) {
			if ($arParams[$paramName]) {
				$needle_key = $paramName;
				$haystack_key = $fieldCode;
			}
		}
		$arResult['NONE_SELECTED'] = true;

		if ($needle_key !== null && $haystack_key !== null) {
			if ($ascendant)
				$arAscendantSections = array();
			foreach ($arResult['SECTIONS'] as $i=>&$arSection) {
				if ($arParams[$needle_key] === $arSection[$haystack_key]) {
					$arSection['SELECTED'] = true;
					$arResult['SECTION_SELECTED_INDEX'] = $i;
					$arResult['NONE_SELECTED'] = false;
					if ($ascendant)
						for($depth_i = $arSection['DEPTH_LEVEL'] - 1; $depth_i > $arResult["SECTION"]["DEPTH_LEVEL"]; --$depth_i) {
							$arAscendantSections[$depth_i]["DESCENDANT_SELECTED"] = true;
						}
					break;
				}
				if ($ascendant)
					$arAscendantSections[$arSection['DEPTH_LEVEL']] = &$arSection;
			}
		}
	}

	/**
	 * для подсчета количества элементов в разделах
	 * @param $arResult
	 * @param null $arParams
	 */
	public static function sectionsCountElements(&$arResult, $arParams = null, $bDeleteEmpty = true, $bCountRoot = false)
	{
		if ($arParams !== null)
			if ((is_bool($arParams['COUNT_ELEMENTS']) && $arParams['COUNT_ELEMENTS']) ||
				(!is_bool($arParams['COUNT_ELEMENTS']) && $arParams['COUNT_ELEMENTS']=='Y'))
				$bSkipCount = true;

		if (!$bSkipCount) {
			if (!\CModule::IncludeModule('iblock')) return;
			$arSectionIds = Array();
			foreach ($arResult['SECTIONS'] as $i => &$arSection)
				$arSectionIds[$arSection['ID']] = $i;
			unset($arSection);

			if (count($arSectionIds)) {
				$rsSections = \CIBlockSection::GetList(Array(), Array('ID' => array_keys($arSectionIds), 'CNT_ACTIVE' => 'Y'), true, Array('ID'));
				while ($arSection = $rsSections->GetNext())
					$arResult['SECTIONS'][$arSectionIds[$arSection['ID']]]['ELEMENT_CNT'] = $arSection['ELEMENT_CNT'];
			}
		}

		// Для корневой ссылки
		if ($arParams !== null && $bCountRoot) {
			$arResult['TOTAL_ELEMENTS'] = \CIBlockElement::GetList(Array(), Array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ACTIVE' => 'Y', 'CHECK_DATES' => $arParams['CHECK_DATES'] ? 'Y': 'N'), Array());
		}

		if ($bDeleteEmpty) {
			foreach ($arResult['SECTIONS'] as $i => &$arSection) {
				if ($arSection['ELEMENT_CNT'] <= 0)
					unset($arResult['SECTIONS'][$i]);
			}
		}

	}

	/**
	 * для подсчета разделам их дочерних разделов
	 * для определения у дочерних разделов их родительских разделов
	 * @param $arResult
	 * @param $arParams
	 * @param bool $skipTopLevel - не подсчитывать для верхнего уровня разделов
	 */
	public static function sectionsCountChildren(&$arResult, &$arParams, $skipTopLevel = false)
	{
		// подсчет дочерних разделов
		$descendants = array();
		foreach($arResult['SECTIONS'] as $i=>&$arSection)
		{
			$descendants[$arSection['DEPTH_LEVEL']] = &$arSection;
			if (!isset($arSection['CHILDREN_COUNT']))
			{
				$arSection['CHILDREN_COUNT'] = 0;
				$arSection['CHILDREN'] = array();
			}
			if ($arSection['DEPTH_LEVEL'] > ($arResult['SECTION']['DEPTH_LEVEL']+1))
			{
				$arSection['PARENT_SECTION'] = &$descendants[$arSection['DEPTH_LEVEL']-1];
				$descendants[$arSection['DEPTH_LEVEL']-1]['CHILDREN_COUNT']++;
				$descendants[$arSection['DEPTH_LEVEL']-1]['CHILDREN'][$i] = &$arSection;
			}
			elseif (!$skipTopLevel)
			{
				if (!isset($arResult['TOP_LEVEL']['CHILDREN_COUNT']))
				{
					$arResult['TOP_LEVEL']['CHILDREN_COUNT'] = 0;
					$arResult['TOP_LEVEL']['CHILDREN'] = Array();
					$arResult['TOP_LEVEL']['DEPTH_LEVEL'] = $arResult['SECTION']['TOP_DEPTH'];
				}
				$arResult['TOP_LEVEL']['CHILDREN_COUNT']++;
				$arResult['TOP_LEVEL']['CHILDREN'][$i] = &$arSection;
			}
		}
		unset($descendants);
	}

	/**
	 * TODO: проверить на работоспособность
	 * для определения разделам у одного родителя
	 * первого и последнего раздела
	 * @see Menu::MenuLinksBetterWhereabouts
	 * перед вызовом надо вызвать @see CatalogSectionList::SectionsCountChildren
	 * @param $arResult
	 * @param $arParams
	 */
	public static function sectionsBetterWhereabouts(&$arResult, &$arParams)
	{
		foreach($arResult['SECTIONS'] as &$arSection)
		{
			if ($arSection['CHILDREN_COUNT'])
			{
				reset($arSection['CHILDREN']);
				$arSection['CHILDREN']['POS_FIRST'] = true;
				end($arSection['CHILDREN']);
				$arSection['CHILDREN']['POS_LAST'] = true;
			}
		}
		if (isset($arResult['TOP_LEVEL']) && $arResult['TOP_LEVEL']['CHILDREN_COUNT']) {
			reset($arResult['TOP_LEVEL']['CHILDREN']);
			$arResult['TOP_LEVEL']['CHILDREN']['POS_FIRST'] = true;
			end($arResult['TOP_LEVEL']['CHILDREN']);
			$arResult['TOP_LEVEL']['CHILDREN']['POS_LAST'] = true;
		}
	}

	/**
	 * для показа только разделов, которые видны в зависимости от текущего раздела
	 * определяемого функцией @see CatalogSectionList::SectionsSelected
	 * перед вызовом надо вызвать @see CatalogSectionList::SectionsCountChildren, @see CatalogSectionList::SectionsSelected
	 * @param $arResult
	 * @param $arParams
	 */
	public static function sectionsShowOnlyActive(&$arResult, &$arParams)
	{
		// поиск выбранного раздела
		if (!$arResult['NONE_SELECTED']) {
			$arSection = &$arResult['SECTIONS'][$arResult['SECTION_SELECTED_INDEX']];
			$section_selected_depth = $arSection['DEPTH_LEVEL'];
			// echo '<pre>'.print_r($arSection,true).'</pre>';
			do {
				if ($section_selected_depth != $arSection['DEPTH_LEVEL']) $arSection['DESCENDANT_SELECTED'] = true;
				if (($section_selected_depth == $arSection['DEPTH_LEVEL']) || ($arSection['CHILDREN_COUNT'] > 1))
					foreach($arSection['CHILDREN'] as &$arChildSection)
						$arChildSection['VISIBLE_CHILD'] = true;
			} while (isset($arSection['PARENT_SECTION']) && ($arSection = &$arSection['PARENT_SECTION']));
			unset($arSection, $arChildSection);
		}

		foreach($arResult['SECTIONS'] as $i => &$arSection) {
			if ($arSection['DEPTH_LEVEL'] > ($arResult['SECTION']['DEPTH_LEVEL']+1) && !$arSection['SELECTED'] && !$arSection['DESCENDANT_SELECTED'] && !$arSection['VISIBLE_CHILD'])
				unset($arResult['SECTIONS'][$i]);
		}
		$arResult['SECTIONS_COUNT'] = count($arResult['SECTIONS']);

	}

}