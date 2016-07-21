<?
namespace Tools\Snippets\Components;

// сниппеты для компонента bitrix:main.feedback
class MainFeedback
{
	private function __construct() {}
	/**
	 * для обработки текстов ошибок
	 * @param $arResult
	 * @param $arParams
	 */
	public static function feedbackError(&$arResult, &$arParams)
	{
		if (count($arResult['ERROR_MESSAGE'])) {
			foreach ($arResult['ERROR_MESSAGE'] as &$error) {
				if ($error == GetMessage('MF_REQ_NAME')) {
					$arResult['NAME_ERROR'] = true;
				} elseif ($error == GetMessage('MF_REQ_EMAIL') || $error == GetMessage('MF_EMAIL_NOT_VALID')) {
					$arResult['EMAIL_ERROR'] = true;
				} elseif ($error == GetMessage('MF_REQ_MESSAGE')) {
					$arResult['MESSAGE_ERROR'] = true;
				} elseif ($error == GetMessage('MF_CAPTCHA_WRONG') ||
					$error ==
					(strlen(GetMessage('MF_CAPTHCA_EMPTY')) ?
						GetMessage('MF_CAPTHCA_EMPTY'):
						GetMessage('MF_CAPTCHA_EMPTY'))
				) {
					$arResult['CAPTCHA_ERROR'] = true;
				}

			}
		}
	}

	/**
	 * для получения обратной ссылки после отправки формы
	 * @param $arResult
	 * @param $arParams
	 */
	public static function feedbackBackUrl(&$arResult, &$arParams)
	{
		if (strlen($arResult['OK_MESSAGE']) > 0)
			$arResult['BACK_URL'] = $GLOBALS['APPLICATION']->GetCurPageParam('', array('PHPSESSID', 'clear_cache', 'success'));
	}

	/**
	 * для задания js параметров
	 * @param $arResult
	 * @param $arParams
	 * @param $obj
	 */
	public static function feedbackJsParams(&$arResult, &$arParams, &$obj)
	{
		$arResult['JS_PARAMS'] = Array('VISUAL' => Array('ID' => $obj->GetEditAreaId('feedback')));
	}
}