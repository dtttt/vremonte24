<?
namespace Tools\Snippets\Components;

// сниппеты для компонента bitrix:catalog.filter
class CatalogFilter
{
	private function __construct() {}

	/**
	 * для перевода полей "Простой чекбокс (строка)" и "Простой чекбокс (число)" из строки в чекбокс
	 * @param $arResult
	 * @param $arParams
	 */
	public static function filterASDCheckboxes(&$arResult, &$arParams)
	{
		$arFilter = Array('IBLOCK_ID' => $arParams['IBLOCK_ID']);
		foreach($arResult['arrProp'] as $i => &$arPropInfo) {
			// инициализация
			if (strlen($arPropInfo['CODE'])) {
				$arFilter['CODE'] = $arPropInfo['CODE'];
			} else {
				unset($arFilter['CODE']);
				$arFilter['ID'] = $i;
			}
			// изменение
			$rsProp = \CIBlockProperty::GetList(Array(), $arFilter);
			if ($arProp = $rsProp->GetNext()) {
				$arPropInfo['PROPERTY_USER_TYPE'] = $arProp['USER_TYPE'];
				$arPropInfo['PROPERTY_FULL_TYPE'] = $arPropInfo['PROPERTY_TYPE'].':'.$arProp['USER_TYPE'];
			}
		}

		foreach($arResult['ITEMS'] as $code => &$arItem) {
			// поиск поля фильтра - свойства элемента
			if (!preg_match('#^PROPERTY_(.*)$#', $code, $matches)) continue;
			if (!array_key_exists($matches[1], $arResult['arrProp'])) continue;
			$arPropInfo = &$arResult['arrProp'][$matches[1]];
			if ($arPropInfo['PROPERTY_FULL_TYPE'] == 'S:SASDCheckbox') {
				$arItem['INPUT'] = '<input type="checkbox" name="'.$arItem['INPUT_NAME'].'" value="Y"'.('Y' == $arItem['INPUT_VALUE'] ? ' checked': '').'>';
			} elseif ($arPropInfo['PROPERTY_FULL_TYPE'] == 'N:SASDCheckboxNum') {
				$arItem['INPUT'] = '<input type="checkbox" name="'.$arItem['INPUT_NAME'].'" value="1"'.('1' == $arItem['INPUT_VALUE'] ? ' checked': '').'>';
			}
		}
	}

	/**
	 * для смены атрибутов полям фильтра
	 * кастомизируется как надо для полей фильтра
	 * TODO: добавить правильные параметры, чтобы кастомизировать через них
	 * @param $arResult
	 * @param $arParams
	 * @param $bASDCheckboxes - преобразовать свойства "Простой чекбокс (строка)" и "Простой чекбокс (число)" из строки в чекбокс
	 */
	public static function filterEditInputsHtml(&$arResult, &$arParams)
	{
		// Изменение полей фильтра
		foreach ($arResult['ITEMS'] as $code => &$arItem)
		{
			$dom = new \DOMDocument();
			@$dom->loadHTML('<?xml encoding="'.SITE_CHARSET.'" ?>' . $arItem['INPUT']);
			$x = new \DOMXPath($dom);

			$nodes = $x->query('//input|//textarea|//select|//button');
			if ($nodes->length > 0) {
				foreach($nodes as $node) {
					// классы
					$arClasses = Array();
					if (!in_array($node->getAttribute('type'), Array('file', 'checkbox', 'radio'))) $arClasses[] = 'form-control';
					// ошибка
					//if (is_array($arResult['FORM_ERRORS']) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS']))
					//	$arClasses[] = 'has-error';
					if (count($arClasses))
					{
						$oldValue = $node->getAttribute('class');
						if (strlen($oldValue))
						{
							$arClassesOld = explode(' ', $oldValue);
							$arClassesNew = array_diff($arClasses, $arClassesOld);
							if (count($arClassesNew))
								$node->setAttribute('class', implode(' ', array_merge($arClassesOld, $arClassesNew)));
						}
						else
						{
							$arClassesNew = $arClasses;
							$node->setAttribute('class', implode(' ', $arClassesNew));
						}
					}

					if (!isset($arItem['ID'])) {
						if ( ($id = $node->getAttribute('id')) ) {
							$arItem['ID'] = $id;
						} elseif ( $name = $node->getAttribute('name') ) {
							$node->setAttribute('id', $name);
							$arItem['ID'] = $name;
						}
					}

				}
				$arItem['INPUT'] = \Tools\Snippets\Common::trimSavedDoc($dom->saveHtml());
			}

		}
	}

	/**
	 * Сортировать поля фильтра в порядке их указания в параметрах
	 * Сначала идут FIELD_CODE, потом PROPERTY_CODE
	 * @param $arResult
	 * @param $arParams
	 */
	public static function sortItemsByParamOrder(&$arResult, &$arParams)
	{
		$arItems = Array();
		foreach($arParams['FIELD_CODE'] as &$code) {
			if (isset($arResult['ITEMS'][$code])) {
				$arItems[$code] = $arResult['ITEMS'][$code];
				unset($arResult['ITEMS'][$code]);
			}
		}

		$arPropertyIds = Array();
		foreach($arParams['PROPERTY_CODE'] as &$code) {
			$rsProp = \CIBlockProperty::GetById($code, $arParams['IBLOCK_ID']);;
			if ($arProp = $rsProp->GetNext())
				$arPropertyIds[$arProp['ID']] = $arProp['ID'];
		}

		foreach($arPropertyIds as &$propId) {
			$key = 'PROPERTY_'.$propId;
			if (isset($arResult['ITEMS'][$key])) {
				$arItems[$key] = $arResult['ITEMS'][$key];
				unset($arResult['ITEMS'][$key]);
			}
		}

		$arResult['ITEMS'] = array_merge(
			$arItems,
			$arResult['ITEMS']
		);
	}

	/**
	 * Проверяет, заданы ли значения фильтра
	 * @param $arResult
	 * @param $arParams
	 * @param bool $strict - если true, делает подробную проверку на заданные значения полей; если false, проверяет только параметр set_filter
	 */
	public static function filterCheckSet(&$arResult, &$arParams, $strict = false)
	{
		if ($strict) {
			$arResult['FILTER_SET'] = false;
			foreach($arResult['ITEMS'] as &$arItem) {
				if (is_array($arItem['INPUT_VALUE'])) {
					foreach($arItem['INPUT_VALUE'] as &$input_value) {
						if (strlen($input_value)) {
							$arResult['FILTER_SET'] = true;
							break 2;
						}
					}
				} elseif (strlen($arItem['INPUT_VALUE'])) {
					$arResult['FILTER_SET'] = true;
					break;
				}
			}
		} else {
			$arResult['FILTER_SET'] = strlen($_REQUEST['set_filter']) > 0;
		}
	}

	/**
	 * Парсит параметры формы подключаемого компонента фильтра
	 * @param $ComponentParams
	 * @param null $ParamName
	 * @param bool $bParamOnly
	 * @return array|bool
	 */
	public static function parseComponentFilterParams($ComponentParams, $ParamName = null, $bParamOnly = false, $set_filter = 'set_filter', $del_filter = 'del_filter')
	{
		// Записываем html код компонента в буфер
		ob_start();
		global $APPLICATION;

		if (call_user_func_array(Array($GLOBALS['APPLICATION'], 'IncludeComponent'), $ComponentParams) === false) {
			ob_end_clean();
			return false;
		} else {
			$contents = ob_get_contents();
			ob_end_clean();
		}
		// Читаем html
		$dom = new \DOMDocument();
		@$dom->loadHTML('<?xml encoding="'.SITE_CHARSET.'" ?>' . $contents);
		$x = new \DOMXPath($dom);
		// Инициализация
		$FilterNameSafe = preg_quote($ComponentParams[2]['FILTER_NAME']);
		if ($ParamName !== null) $ParamNameSafe = preg_quote($ParamName);
		$arParams = Array();
		// Проходим по всем элементам формы
		// TODO: xpath регистронезависимо
		foreach($x->query("//form//*[local-name()='input' or local-name()='textarea' or local-name()='select' or local-name()='button'][@name!='']") as $node) {
			$inputName = $node->getAttribute('name');
			$inputValue = $node->tagName == 'textarea'? $node->nodeValue: $node->getAttribute('value');
			if ($bParamOnly === false && preg_match('/^(?!'.$FilterNameSafe.')/', $inputName)) {
				if (strcasecmp($inputName, $set_filter)===0) {
					$arParams[$inputName] = Array(
						'name' => $inputName,
						'value' => $inputValue
					);
				}
				continue;
			}
			// arPortfolioFilter_pf[(1:SERVICES)](2:[])
			if (preg_match('/
			^'.$FilterNameSafe.'                                # имя фильтра
			\_[^\[]*                                            # суффикс параметра
			\[(                                                 # открытие массива
			'.($ParamName === null? '[^\]]+': $ParamNameSafe).' # название переменной
			)\]                                                 # закрытие массива
			(\[\])?                                             # множественный параметр
			$/x', $inputName, $matches)) {
				$arParams[$matches[1]] = Array(
					'name' => $inputName,
					'multiple' => strlen($matches[2]) > 0,
					'value' => $inputValue,
					'is_param' => true,
				);
			}
		}
		if (!isset($arParams[$set_filter])) {
			$arParams[$set_filter] = Array(
				'name' => $set_filter,
				'value' => 'Y',
			);
		}
		return $arParams;
	}

	/**
	 * Возвращает ссылку из массива парсенных параметров
	 * @param $arParams
	 * @return string
	 */
	public static function filterParamsToString($arParams, $url = null)
	{
		$result = '';
		if ($url !== null) $result .= (string)$url;
		if (!is_array($arParams)) return $result;
		$arQuery = Array();
		foreach ($arParams as &$arParam) {
			if ($arParam['is_param']) {
				if ((!$arParam['multiple']) && is_array($arParam['value']) && count($arParam['value']) > 1)
					$arParam['value'] = reset($arParam['value']);

				if (is_array($arParam['value']))
					foreach($arParam['value'] as &$item)
						$arQuery[] = $arParam['name'].'='.$item;
				else
					$arQuery[] = $arParam['name'].'='.$arParam['value'];
			} else {
				$arQuery[] = $arParam['name'].'='.$arParam['value'];
			}
		}
		if ($url !== null) $result .= (strpos($url, '?')===false? '?': '&');
		$result .= implode('&', $arQuery);
		return $result;
	}
}