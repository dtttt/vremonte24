<?
namespace Tools\Snippets;

class Component
{
	private function __construct() {}

	/******************************
	Complex template
	 *******************************/

	/**
	 * для переадресации со страниц комплексного компонента, которые не нужны
	 * @param $componentTemplate
	 * @param null $toPage
	 */
	public static function disablePage(&$componentTemplate, $toPage = null)
	{
		if (!$componentTemplate instanceof \CBitrixComponentTemplate || !$componentTemplate->__bInited) return;

		if ($componentPage = self::getRedirectUrl($componentTemplate, $toPage)) {
			LocalRedirect($componentPage);
		}

	}

	/**
	 * помощник для @see \Tools\Snippets\Component::disablePage
	 * @param $componentTemplate
	 * @param null $toPage
	 * @return null
	 */
	private static function getRedirectUrl(&$componentTemplate, $toPage = null)
	{
		$component = &$componentTemplate->__component;
		$arResult = &$component->arResult;

		// проверка страницы шаблона комплексного компонента
		if ($toPage !== null && is_array($arResult['URL_TEMPLATES']) && strlen($arResult['URL_TEMPLATES'][$toPage])) {
			$componentPage = $toPage;
		} else {
			$componentPage = null;
			switch ($component->GetName()) {
				case 'bitrix:news':
					$componentPage = 'news';
					break;
				case 'bitrix:catalog':
					$componentPage = 'sections';
					break;
				case 'bitrix:form':
					$componentPage = 'list';
					break;
			}

			if ($componentPage !== null && (!is_array($arResult['URL_TEMPLATES']) || !strlen($arResult['URL_TEMPLATES'][$componentPage]))) {
				$componentPage = null;
			}
		}

		// определение адреса куда пойдет переадресация
		if ($componentPage !== null) {
			if ($componentPage == $componentTemplate->GetPage() && @constant('SITE_DIR'))
				$redirectUrl = SITE_DIR;
			else
				$redirectUrl = $arResult['URL_TEMPLATES'][$componentPage];
		} else {
			if (strlen($arResult['FOLDER']))
				$redirectUrl = $arResult['FOLDER'];
			elseif (@constant('SITE_DIR'))
				$redirectUrl = SITE_DIR;
			else
				$redirectUrl = null;
		}

		// защита от циклической переадресации
		if ($redirectUrl && $GLOBALS['APPLICATION']->GetCurPage(true) != $redirectUrl && $GLOBALS['APPLICATION']->GetCurPage(false) != $redirectUrl)
			return $redirectUrl;
	}
	/* Complex template - end */


	/******************************
	Helpers
	*******************************/

	/**
	 * для получения массива элементов из $arResult
	 * для работы со списком и одним элементом
	 * @param $arResult
	 * @param string $itemsKey
	 */
	public static function &getItems(&$arResult, $itemsKey = 'ITEMS') {
		if (isset($arResult[$itemsKey])) $arItems = &$arResult[$itemsKey];
		else $arItems = Array(&$arResult);
		return $arItems;
	}

	/******************************
	Template
	 *******************************/

	/**
	 * для получения уникального кода компонента
	 * @param $arResult
	 * @param $arParams
	 * @param $obj
	 * @param bool $bWriteInParams - записывать в js-массив в $arParams, вместо $arResult
	 */
	public static function jsParams(&$arResult, &$arParams, &$obj, $bWriteInParams = false)
	{
		if ($bWriteInParams)
			$arParams['JS_PARAMS']['visual']['main'] = $obj->GetEditAreaId('main');
		else
			$arResult['JS_PARAMS']['visual']['main'] = $obj->GetEditAreaId('main');
	}
}