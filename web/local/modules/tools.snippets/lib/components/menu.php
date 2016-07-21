<?
namespace Tools\Snippets\Components;

// сниппеты для компонента bitrix:menu
class Menu
{
	private function __construct() {}

	/**
	 * Для перевода массива пунктов меню в индекс 'ITEMS'
	 * @param $arResult
	 * @param $arParams
	 * @param $removeHigherThanMaxLvl - true/false - удалять ли пункты выше предельного уровня меню (параметр MAX_LEVEL)
	 */
	public static function prepareResult(&$arResult, &$arParams, $removeHigherThanMaxLvl = false)
	{
		$arResult = Array('ITEMS' => $arResult);
		if ($removeHigherThanMaxLvl) {
			foreach($arResult['ITEMS'] as $i => &$arItem)
				if ($arItem['DEPTH_LEVEL'] > $arParams['MAX_LEVEL']) unset($arResult['ITEMS'][$i]);
		}
	}

	/**
	 * для удаления неактивных ссылок
	 * перед вызовом надо вызвать @see Menu::PrepareResult
	 * @param $arResult
	 * @param $arParams
	 */
	public static function menuDeleteDisabledLinks(&$arResult, &$arParams)
	{
		foreach($arResult['ITEMS'] as $i=>&$arItem)
			if (isset($arItem['PERMISSION']) && $arItem['PERMISSION'] <= 'D') unset($arResult[$i]);
	}

	/**
	 * TODO: проверить на работоспособность
	 * для определения ссылки ведущий на внешний ресурс
	 * перед вызовом надо вызвать @see Menu::PrepareResult
	 * @param $arResult
	 * @param $arParams
	 * @param bool $forceCurrentSiteLinkRelative - нужно ли перевести абсолютные ссылки текущего сайта в относительные
	 * @param bool $disableBrokenCurrentSiteLink - нужно ли выключить сломанные ссылки текущего сайта
	 */
	public static function menuLinkType(&$arResult, &$arParams, $forceCurrentSiteLinkRelative = false, $disableBrokenCurrentSiteLink = false)
	{
		if (empty($arResult['ITEMS'])) return;
		/**
		 * Получение информации по текущим сайтам
		 * @see CSecurityRedirect::BeforeLocalRedirect
		 */
		static $arEntity;
		if (!isset($arEntity)) {
			$rsSites = \CSite::GetList(($by=''), ($order=''));
			$arEntity = Array('SITES' => Array(), 'ONE_DOMAIN' => true);
			$prevDomain = null;
			while ($arSite = $rsSites->GetNext())
			{
				$arEntity['SITES'][$arSite['LID']] = Array(
					'LID' => $arSite['LID'],
					'DIR' => $arSite['DIR'],
					'SERVER_NAME' => str_replace("\r", "\n", $arSite['SERVER_NAME']),
					'DOMAINS' => Array(),
				);
				if (!$arSite['DOMAINS']) continue;

				$arDomains = explode("\n", str_replace("\r", "\n", $arSite["DOMAINS"]));
				foreach($arDomains as $domain)
				{
					$domain = trim($domain, " \t\n\r");
					if (!strlen($domain)) continue;
					$arEntity['SITES'][$arSite['LID']]['DOMAINS'][] = $domain;
				}
				$arEntity['SITES'][$arSite['LID']]['TOTAL_DOMAINS'] = array_merge(
					Array($arEntity['SITES'][$arSite['LID']]['SERVER_NAME']),
					$arEntity['SITES'][$arSite['LID']]['DOMAINS']
				);
				foreach($arEntity['SITES'][$arSite['LID']]['TOTAL_DOMAINS'] as &$domain)
				{
					$domain = preg_replace('/^www\./i', '', $domain);
					if ($prevDomain === null) $prevDomain = $domain;
					elseif (strcasecmp($prevDomain, $domain) !== 0) $arEntity['ONE_DOMAIN'] = false;
				}

			}
			uasort($arEntity['SITES'], function($a,$b) {
				return strlen($b['DIR']) - strlen($a['DIR']);
			});
			unset($arSite, $arDomains, $domain);
		}

		foreach($arResult['ITEMS'] as &$arItem)
		{
			// Распарсивание ссылки меню
			$LINK = trim($arItem['LINK']);
			// Поменять решетку (#), пустую строку на javascript:void(0)
			if (!strlen($LINK) || preg_match('/^#+$/', $LINK)) { $arItem['LINK'] = 'javascript:void(0)'; continue; }

			if (\CHTTP::isPathTraversalUri($LINK)) continue;
			$arUrl = parse_url($LINK);
			if (isset($arUrl['user']) || isset($arUrl['pass'])) continue;
			$arUrl['host'] = preg_replace('/^www\./i', '', $arUrl['host']);

			$bHost = strlen($arUrl['host']) > 0;
			if ($bHost) {
				// Определить ведет ли ссылка внешний ресурс
				$bExternal = true;
				foreach ($arEntity['SITES'] as &$arSite) {
					if (in_array($arUrl['host'], $arSite['TOTAL_DOMAINS'])) {
						$bExternal = false;
						break;
					}
				}
			} else $bExternal = false;
			if ($bExternal) $arItem['EXTERNAL_URL'] = true;
			else {
				// Определить ссылке текущего сайта lid сайта
				foreach ($arEntity['SITES'] as &$arSite) {
					if (strpos($arUrl['path'], $arSite['DIR']) === 0) {
						$arItem['SITE_LID'] = $arSite['LID'];
						break;
					}
				}
				// Сделать ссылки текущего сайта относительными
				if ($forceCurrentSiteLinkRelative && $arEntity['ONE_DOMAIN'])
					$arItem['LINK'] = $arUrl['path'].(strlen($arUrl['query']) ? '?'.$arUrl['query'] : '').(strlen($arUrl['fragment']) ? '#'.$arUrl['fragment'] : '');
				// Выключить сломанные ссылки текущего сайта
				if (!$arItem['PARAMS']['FROM_IBLOCK'] && $disableBrokenCurrentSiteLink) {
					$path = $arUrl['path'];
					if (strpos($path, '/') !== 0) $path = '/'.$path;
					if (!file_exists($_SERVER['DOCUMENT_ROOT'].$path) || (file_exists($_SERVER['DOCUMENT_ROOT'].$path) && is_dir($_SERVER['DOCUMENT_ROOT'].$path) && !file_exists($_SERVER['DOCUMENT_ROOT'].$path.'/'.GetDirIndex($path))))
					{
						$arItem['LINK'] = 'javascript:void(0)';
					}
				}
			}

		}
	}

	/**
	 * для смены ссылки - при совпадении пути и ссылки - на главную
	 * перед вызовом надо вызвать @see Menu::PrepareResult
	 * @param $arResult
	 * @param $arParams
	 */
	public static function menuChangeActiveLinkToMainPage(&$arResult, &$arParams)
	{
		if (empty($arResult['ITEMS'])) return;
		if (\Tools\Snippets\Common::checkComponentParam($arParams['CHANGE_ACTIVE_LINK_TO_MAIN_PAGE'], 'Y')) {
			foreach($arResult['ITEMS'] as &$arItem)
			{
				if ($arItem['SELECTED'] && ($GLOBALS['APPLICATION']->GetCurPage(true)==$arItem['LINK'] || $GLOBALS['APPLICATION']->GetCurPage(false)==$arItem['LINK']))
					$arItem['LINK'] = SITE_DIR;
			}
		}

	}

	/**
	 * для определения ссылкам у одного родителя:
	 * предыдущей (PREV_SIBLING = reference/not set) и следующей ссылки (NEXT_SIBLING = reference/not set);
	 * первой (POS_FIRST = true/not set) и последней ссылки (POS_LAST = true/not set)
	 * перед вызовом надо вызвать @see Menu::PrepareResult
	 * @param $arResult
	 * @param $arParams
	 */
	public static function menuLinksBetterWhereabouts(&$arResult, &$arParams)
	{
		$DEPTH_LEVEL = 0;
		$arLastLi = array();

		foreach($arResult['ITEMS'] as &$arItem)
		{
			if ($arItem['DEPTH_LEVEL'] > $arParams['MAX_LEVEL']) continue;

			if ($arItem['DEPTH_LEVEL'] > $DEPTH_LEVEL)
			{
				$arItem['POS_FIRST'] = true;
				$arLastLi[$arItem['DEPTH_LEVEL']] = &$arItem;
			}
			elseif ($arItem['DEPTH_LEVEL'] < $DEPTH_LEVEL)
			{
				for($i = $DEPTH_LEVEL; $i > $arItem['DEPTH_LEVEL']; $i--)
				{
					$arLastLi[$i]['POS_LAST'] = true;
				}
				for($i = $DEPTH_LEVEL-1; $i >= $arItem['DEPTH_LEVEL']; $i--)
				{
					$arLastLi[$i]['NEXT_SIBLING'] = &$arItem;
					$arItem['PREV_SIBLING'] = &$arLastLi[$i];
				}
			}
			else
			{
				$arLastLi['NEXT_SIBLING'] = &$arItem;
				$arItem['PREV_SIBLING'] = &$arLastLi[$DEPTH_LEVEL];
				$arLastLi[$arItem['DEPTH_LEVEL']] = &$arItem;
			}

			$DEPTH_LEVEL = $arItem['DEPTH_LEVEL'];
		}
		$arLastLi[$DEPTH_LEVEL] = &$arItem;

		for ($i = $DEPTH_LEVEL; $i > 0; $i--)
		{
			$arLastLi[$i]['POS_LAST'] = true;
		}
	}

	/**
	 * TODO: проверить на работоспособность
	 * для подсчета пунктам их вложенных пунктов
	 * для определения у вложенных пунктов их содержащих пунктов
	 * перед вызовом надо вызвать @see Menu::PrepareResult
	 * @param $arResult
	 * @param $arParams
	 * @param bool $skipTopLevel - не подсчитывать для корневых пунктов меню
	 */
	public static function menuLinksCountChildren(&$arResult, &$arParams, $skipTopLevel = false)
	{
		// подсчет дочерних разделов
		$descendants = array();
		foreach($arResult['ITEMS'] as $i => &$arItem)
		{
			$descendants[$arItem['DEPTH_LEVEL']] = &$arItem;
			if (!isset($arItem['CHILDREN_COUNT']))
			{
				$arItem['CHILDREN_COUNT'] = 0;
				$arItem['CHILDREN'] = array();
			}
			if ($arItem['DEPTH_LEVEL'] > 1)
			{
				$arItem['PARENT_ITEM'] = &$descendants[$arItem['DEPTH_LEVEL']-1];
				$descendants[$arItem['DEPTH_LEVEL']-1]['CHILDREN_COUNT']++;
				$descendants[$arItem['DEPTH_LEVEL']-1]['CHILDREN'][$i] = &$arItem;
			}
			elseif (!$skipTopLevel)
			{
				if (!isset($arResult['ROOT_ITEMS']))
				{
					$arResult['ROOT_ITEMS']= Array();
				}
				$arResult['ROOT_ITEMS'][$i] = &$arItem;
			}
		}
		unset($descendants);
	}


}