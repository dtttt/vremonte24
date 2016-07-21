<?
namespace Tools\Snippets;
IncludeModuleLangFile(__FILE__);

class Common
{
	private function __construct() {}
	public static function addParams($path = null, $arguments)
	{
		if ($path === true)
			$path = $GLOBALS['APPLICATION']->GetCurPage();
		$resultPath = '';
		$resultPath .= $path;
		$delimiter = strpos($resultPath, '?')===false ? '?' : '&';
		foreach ($arguments as $key => &$value) {
			$resultPath .= $delimiter.$key.'='.$value;
			if ($delimiter == '?') $delimiter = '&';
		}
		return $resultPath;
	}

	/**
	 * Удаляет лишнее обрамление после метода @see DOMDocument::saveHTML
	 * @param $string
	 * @return string
	 */
	public static function trimSavedDoc($string)
	{
		return preg_replace('~<\?xml.*?\?\>|<(?:!DOCTYPE|/?(?:html|head|body))[^>]*>\s*~i', '', $string).PHP_EOL;
	}

	// Проверка значения компонента
	public static function checkComponentParam($param, $neededValue, $notEqual = false)
	{
		if (is_bool($neededValue) || $neededValue == 'Y' || $neededValue == 'N') {
			if ($param == 'Y' || $param == 'N') $param = $param == 'Y';
			if ($neededValue == 'Y' || $neededValue == 'N') $neededValue = $neededValue == 'Y';

			return $notEqual ? $param != $neededValue : $param == $neededValue;
		}
	}

	/**
	 * Для склонения слов, возвращает число, в зависимости от значения числа:
	 * 1 - *дерево*
	 * 2 - *дерева*
	 * 3 - *деревьев*
	 * @param $num
	 * @return string
	 */
	public static function declension($num)
	{
		$num = self::fixNum($num);

		if (strpos($num, '.') !== false)
			return '2';
		else {
			if ($num < 0) $num = -$num;
			$m = $num % 10; $j = $num % 100;
			if ($m == 0 || $m >=5 || ($j >= 10 && $j <= 20)) return '3';
			if ($m >= 2 && $m <= 4) return '2';
			return '1';
		}
	}

	/**
	 * Возвращает форматированный размер файла из байтов в подходящем измерении размера
	 * (если до мегабайт в размере выводятся два знака после запятой, с мегабайтами, гигабайтами и выше знаков после запятой нет)
	 * @param $size
	 * @return string
	 */
	public static function getFormattedFileSize($size)
	{
		static $sizes;
		if (!isset($sizes)) $sizes = explode('|', GetMessage(\tools_snippets::MODULE_ID . '_FILE_SIZE'));
		for ($i=0; $size > 1024 && $i < count($sizes) - 1; $i++) $size /= 1024;
		return ($i < 2? floor($size): round($size, $i==2? 1: 2)).' '.$sizes[$i];
	}

	/**
	 * Меняет параметры в ссылке
	 * @param null $page
	 * @param string $add_params
	 * @param array $remove_params
	 */
	public static function getPageParam($sUrlPath = NULL, $strParam = "", $arParamKill = Array())
	{
		global $APPLICATION;
		// Определение ссылки
		if ($sUrlPath === NULL || is_bool($sUrlPath)) {
			if (is_bool($sUrlPath)) $sUrlPath = $APPLICATION->GetCurPageParam($sUrlPath);
			else $sUrlPath = $APPLICATION->GetCurPageParam();
		}
		// К списку параметров для удаления пробуем добавить параметры, которые указаны для добавления
		if (is_array($strParam))
		{
			$aParams = $strParam;
			$strParam = http_build_query($strParam, '', '&');
		}
		else
		{
			$aParams = Array();
			parse_str($strParam, $aParams);
		}
		$arParamKill = array_merge($arParamKill, $aParams);

		// Удаление параметров
		$aParams = Array();
		parse_str(parse_url($sUrlPath, PHP_URL_QUERY), $aParams);
		if (count($aParams))
			foreach($aParams as $key => &$value)
				foreach($arParamKill as &$param)
					if (strcasecmp($param, $key) == 0) { unset($aParams[$key]); break; }
		$strNavQueryString = http_build_query($aParams, '', '&');

		if ($strNavQueryString <> '' && $strParam <> '')
			$strNavQueryString = $strNavQueryString . '&';
		if ($strNavQueryString == '' && $strParam == '')
			return $sUrlPath;
		else
			return (strpos($sUrlPath, '?') === false? $sUrlPath : substr($sUrlPath, 0, strpos($sUrlPath, '?'))).'?'.$strNavQueryString.$strParam;
	}

	/**
	 * Правит число
	 * @param $num
	 * @return float|mixed
	 */
	public static function fixNum($num)
	{
		if ($num == '') return $num;
		$num = str_replace(array("\xc2\xa0", "\xa0", " ", ","), array("", "", "", "."), $num);
		$num = preg_replace('#\.{2}#', '.', $num);
		$num = preg_replace('#^(.+\..+)(\..*)$#', '$1', $num);
		$num = (double)$num;
		return $num;
	}

	/**
	 * Форматирует число
	 * @param $price
	 * @return float|mixed|string
	 */
	public static function formatNum($num, $dec_point = '.', $thousands_sep = '')
	{
		$num = self::fixNum($num);
		$isFloat = strpos($num, '.')!==false;
		if ($isFloat) $num = round($num, 2);
		else $num = floor($num);
		if ($dec_point === NULL) $dec_point = '.';
		if ($thousands_sep === NULL) $thousands_sep = '';
		$num = number_format($num, $isFloat? 2: 0, 'D', 'T');
		$num = str_replace(array('D','T'), array($dec_point, $thousands_sep), $num);
		return $num;
	}
}