<?
namespace Tools\Snippets;

/**
 * Class ComponentImage - для упрощения ресайза картинок
 * TODO: переделать
 * @package Tools\Snippets
 */
class ComponentImage
{
	private function __construct() {}

	/**
	 * для ресайза изображений
	 * @param $arResult
	 * @param $arParams
	 * @param $arOptions
	 * @param string $itemsKey
	 */
	public static function resize(&$arResult, &$arParams, $arOptions, $itemsKey = 'ITEMS', $forceResize = false, $forceResultArray = false)
	{
		if (!\CModule::IncludeModule('fileman')) return;
		if (!strlen($itemsKey)) $itemsKey = 'ITEMS';
		$arItems = &\Tools\Snippets\Component::getItems($arResult, $itemsKey);
		$arOptions = self::checkDefOptions($arOptions);

		// Изменение результата
		foreach($arItems as &$arItem) {
			// Поля картинки
			foreach($arOptions['fields']['names'] as &$field) {

				if (!isset($arItem[$field])) continue;
				$arField = &$arItem[$field];
				$arSizes = self::getArSizes($arOptions['fields']['arSize'], $arOptions);
				$arResizeTypes = self::getResizeTypes($arOptions['fields']['resizeType'], $arOptions);

				$arItem['FIELD_PICTURE'][$field] = Array();
				$arPict = &$arItem['FIELD_PICTURE'][$field];
				foreach ($arSizes as $name => &$arSize) {
					$arFileClone = $arField;
					if ($forceResize) self::fakeSize($arFileClone, $arSize, $arResizeTypes[$name]);
					$arPict[$name] = \CFile::ResizeImageGet($arFileClone, $arSize, $arResizeTypes[$name], true);
				}
				$arPict['NORMAL'] = &$arField;
			}
			if (!$forceResultArray && (count($arOptions['fields']['names']) == 1)) {
				$arItem['FIELD_PICTURE'] = reset($arItem['FIELD_PICTURE']);
			}

			// Свойства картинки
			foreach($arOptions['properties']['names'] as &$property) {
				if (!isset($arItem['DISPLAY_PROPERTIES'][$property])) continue;
				$arProp = &$arItem['DISPLAY_PROPERTIES'][$property];
				$arSizes = self::getArSizes($arOptions['properties']['arSize'], $arOptions);
				$arResizeTypes = self::getResizeTypes($arOptions['properties']['resizeType'], $arOptions);

				$arItem['PROPERTY_PICTURE'][$property] = Array();
				$arPict = &$arItem['PROPERTY_PICTURE'][$property];

				if ($arProp['MULTIPLE'] == 'Y') {
					if (!(count($arProp['VALUE']) > 1))
						$arProp['FILE_VALUE'] = array($arProp['FILE_VALUE']);
				} else {
					$arProp['FILE_VALUE'] = array($arProp['FILE_VALUE']);
				}

				foreach($arProp['FILE_VALUE'] as $i => &$file_value) {
					foreach ($arSizes as $name => &$arSize) {
						$arFileClone = $file_value;
						if ($forceResize) self::fakeSize($arFileClone, $arSize, $arResizeTypes[$name]);
						$arPict[$i][$name] = \CFile::ResizeImageGet($arFileClone, $arSize, $arResizeTypes[$name], true);
					}
					$arPict[$i]['NORMAL'] = &$file_value;
				}
				if ($arProp['MULTIPLE'] != 'Y') {
					$arPict = reset($arPict);
					$arProp['FILE_VALUE'] = reset($arProp['FILE_VALUE']);
				}
			}
			if (!$forceResultArray && (count($arOptions['properties']['names']) == 1)) {
				$arItem['PROPERTY_PICTURE'] = reset($arItem['PROPERTY_PICTURE']);
			}

			// Пользовательские свойства картинки
			foreach($arOptions['uf']['names'] as &$property) {
				if (!isset($arItem[$property])) continue;
				$arProp = &$arItem[$property];
				$arSizes = self::getArSizes($arOptions['uf']['arSize'], $arOptions);
				$arResizeTypes = self::getResizeTypes($arOptions['uf']['resizeType'], $arOptions);

				$arItem['PROPERTY_UF_PICTURE'][$property] = Array();
				$arPict = &$arItem['PROPERTY_UF_PICTURE'][$property];

				foreach($arProp as $i => &$file_value) {
					foreach ($arSizes as $name => &$arSize) {
						$arFileClone = $file_value;
						if ($forceResize) self::fakeSize($arFileClone, $arSize, $arResizeTypes[$name]);
						$arPict[$i][$name] = \CFile::ResizeImageGet($arFileClone, $arSize, $arResizeTypes[$name], true);
					}
					$arPict[$i]['NORMAL'] = &$file_value;
				}
			}
			if (!$forceResultArray && (count($arOptions['uf']['names']) == 1)) {
				$arItem['PROPERTY_UF_PICTURE'] = reset($arItem['PROPERTY_UF_PICTURE']);
			}
		}

	}

	/**
	 * хелпер для @see \Tools\Snippets\ComponentImage::resize
	 * только для типа масштабирования BX_RESIZE_IMAGE_EXACT (масштабирует в прямоугольник $arSize c сохранением пропорций, обрезая лишнее;)
	 * @param $arFile
	 * @param $arSize
	 * @param $resizeType
	 */
	private static function fakeSize(&$arFile, $arSize, $resizeType)
	{
		if ($resizeType != BX_RESIZE_IMAGE_EXACT) return;
		if ($arSize['width'] <= 0 || $arSize['height'] <= 0) return;

		if ($arSize['width'] > $arFile['WIDTH'] || $arSize['height'] > $arFile['HEIGHT']) {
			$bNeedCreatePicture = false;
			$arSourceSize = Array();
			$arDestinationSize = Array();

			\CFile::ScaleImage(
				$arFile['WIDTH'],
				$arFile['HEIGHT'],
				$arSize,
				$resizeType,
				$bNeedCreatePicture,
				$arSourceSize,
				$arDestinationSize
		);

		$arFile['WIDTH'] = $arDestinationSize['width'] + 1;
		$arFile['HEIGHT'] = $arDestinationSize['height'] + 1;
		}
	}

	/**
	 * хелпер для @see \Tools\Snippets\ComponentImage::resize
	 * получает массив из размеров для ресайза
	 * @param $arSize
	 * @param $arOptions
	 * @return array
	 */
	private static function getArSizes($arSize, &$arOptions)
	{
		$arSizes = Array();
		if (is_array($arSize)) {
			if (!is_array(reset($arSize))) $arSizes = Array('THUMB' => $arSize);
			else $arSizes = $arSize;
		} elseif (is_array($arOptions['arSize'])) {
			if (!is_array(reset($arOptions['arSize']))) $arSizes = Array('THUMB' => $arOptions['arSize']);
			else $arSizes = $arOptions['arSize'];
		}

		foreach($arSizes as $i=>&$arSize) {
			if ((int)$arSize[0]<=0 || (int)$arSize[1]<=0) { unset($arSizes[$i]); continue; }
			$arSize['width'] = $arSize[0];
			$arSize['height'] = $arSize[1];
			unset($arSize[0], $arSize[1]);
		}

		return $arSizes;
	}

	/**
	 * хелпер для @see \Tools\Snippets\ComponentImage::resize
	 * получает массив из типов масштабирования для ресайза
	 * @param $resizeType
	 * @param $arOptions
	 * @return array
	 */
	private static function getResizeTypes($resizeType, &$arOptions)
	{
		$resizeTypes = Array();
		if (is_array($resizeType)) {
			if (count($resizeType) == 1) {
				$resizeType0 = reset($resizeType);
				if (is_numeric(key($resizeType))) $resizeTypes = Array('THUMB' => $resizeType0);
				else $resizeTypes = $resizeType;
			} else $resizeTypes = $resizeType;
		} elseif (is_array($arOptions['resizeType'])) {
			if (count($arOptions['resizeType']) == 1) {
				$resizeType0 = reset($arOptions['resizeType']);
				if (is_numeric(key($arOptions['resizeType']))) $resizeTypes = Array('THUMB' => $resizeType0);
				else $resizeTypes = $arOptions['resizeType'];
			} else $resizeTypes = $arOptions['resizeType'];
		}

		foreach($resizeTypes as &$resizeType) {
			if ($resizeType === BX_RESIZE_IMAGE_EXACT || $resizeType === BX_RESIZE_IMAGE_PROPORTIONAL || $resizeType === BX_RESIZE_IMAGE_PROPORTIONAL_ALT)
				continue;
			$resizeType = BX_RESIZE_IMAGE_PROPORTIONAL;
		}

		return $resizeTypes;
	}

	/**
	 * для хранения частоиспользуемых комбинаций
	 * @param $arOptions
	 * @return array
	 */
	public static function checkDefOptions($arOptions)
	{
		if (isset($arOptions['type']) && isset($arOptions['arSize']) && isset($arOptions['resizeType'])) {
			switch (trim((string)$arOptions['type'])) {
				case 0:
				case '':
					return Array(
						'fields' => Array(
							'names' => Array('PREVIEW_PICTURE'),
							'arSize' => $arOptions['arSize'],
							'resizeType' => $arOptions['resizeType'],
						),
					);
					break;
				case 1:
					return Array(
						'fields' => Array(
							'names' => Array('PREVIEW_PICTURE', 'DETAIL_PICTURE'),
							'arSize' => $arOptions['arSize'],
							'resizeType' => $arOptions['resizeType'],
						),
					);
					break;
				case 2:
					return Array(
						'fields' => Array(
							'names' => Array('DETAIL_PICTURE', 'PREVIEW_PICTURE'),
							'arSize' => $arOptions['arSize'],
							'resizeType' => $arOptions['resizeType'],
						),
					);
					break;
				case 3:
					return Array(
						'fields' => Array(
							'names' => Array('DETAIL_PICTURE', 'PREVIEW_PICTURE'),
							'arSize' => $arOptions['arSize'],
							'resizeType' => $arOptions['resizeType'],
						),
						'properties' => Array(
							'names' => Array('MORE_PHOTO'),
							'arSize' => $arOptions['arSize'],
							'resizeType' => $arOptions['resizeType'],
						),
					);
					break;
			}
		}
		return $arOptions;
	}

}