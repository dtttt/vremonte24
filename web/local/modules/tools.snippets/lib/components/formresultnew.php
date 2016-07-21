<?
namespace Tools\Snippets\Components;

// сниппеты для компонента bitrix:form.result.new
class FormResultNew
{
	private function __construct() {}
	/**
	 * для обработки текстов ошибок
	 * @param $arResult
	 * @param $arParams
	 */
	public static function formErrors(&$arResult, &$arParams)
	{
		// Список ошибок
		if (is_array($arResult['FORM_ERRORS']))
		{
			$answer_errors = array();
			$arFormErrors = $arResult['FORM_ERRORS'];
			foreach($arFormErrors as $i => &$error) {
				// Проверка ошибки в капче
				if ($error == GetMessage('FORM_WRONG_CAPTCHA')) {
					$arResult['CAPTCHA_ERROR'] = true;
				} elseif ($arParams['USE_EXTENDED_ERRORS'] == 'Y') {
					// Переделка текста ошибок
					if (preg_match('#^'.preg_quote(GetMessage('FORM_EMPTY_REQUIRED_FIELDS')).'\s*(.*)$#', $error, $matches)) {
						$answer_errors[] = $matches[1];
						unset($arFormErrors[$i]);
					}
				}
			}
			if (count($answer_errors)) {
				$arResult['FORM_ERRORS_TEXT'] = '';
				if (count($arFormErrors)) $arResult['FORM_ERRORS_TEXT'] .= implode('<br>', $arFormErrors) . '<br>';
				$arResult['FORM_ERRORS_TEXT'] .= GetMessage('FORM_EMPTY_REQUIRED_FIELDS') . '<br>&nbsp;&nbsp;&raquo;&nbsp;"' . implode('"<br>&nbsp;&nbsp;&raquo;&nbsp;"', $answer_errors) . '"';
				$arResult['FORM_ERRORS_TEXT'] = ShowError($arResult['FORM_ERRORS_TEXT']);
			}
		}
	}

	/**
	 * для получения обратной ссылки после отправки формы
	 * @param $arResult
	 * @param $arParams
	 */
	public static function formBackUrl(&$arResult, &$arParams)
	{
		if (strlen($arParams['BACK_URL'])) {
			$arResult['BACK_URL'] = $arParams['BACK_URL'];
		} else {
			$arResult['BACK_URL'] = $arParams['SEF_MODE'] == 'Y'?
				(strlen($arParams['SEF_FOLDER']) ? $arParams['SEF_FOLDER'] : SITE_DIR)
				:
				$GLOBALS['APPLICATION']->GetCurPageParam('', array('PHPSESSID', 'clear_cache', 'formresult', (strlen($arParams['VARIABLE_ALIASES']['RESULT_ID'])? $arParams['VARIABLE_ALIASES']['RESULT_ID']: 'RESULT_ID') ));
		}
	}

	/**
	 * для смены текста об успешной отправке
	 * @param $arResult
	 * @param $arParams
	 */
	public static function formSuccessText(&$arResult, &$arParams)
	{
		// Инициализация
		$arParams['SEND_MESSAGE_TEXT'] = strlen($arParams['SEND_MESSAGE_TEXT']) ? htmlspecialcharsback(htmlspecialcharsback(htmlspecialcharsback($arParams['SEND_MESSAGE_TEXT']))) : '';

		// Меняем текст о созданном результате
		if ($arResult['isFormNote'] == 'Y' && strlen($arParams['SEND_MESSAGE_TEXT']))
		{
			$pattern = preg_replace('/#RESULT_ID#/', '(.*)', preg_quote(GetMessage('FORM_NOTE_ADDOK')));
			$pattern = '/^'.$pattern.'$/';
			if (preg_match($pattern, $arResult['FORM_NOTE'], $matches))
			{
				$result_id = $matches[1];
				if (!$result_id) $result_id = (int)$_GET['RESULT_ID'];
				$arResult['FORM_NOTE'] = str_replace('#RESULT_ID#', $result_id, isset($arParams['~SEND_MESSAGE_TEXT'])? htmlspecialchars_decode($arParams['SEND_MESSAGE_TEXT']): $arParams['SEND_MESSAGE_TEXT']);
			}
		}
	}

	/**
	 * для смены текста кнопки отправки
	 * @param $arResult
	 * @param $arParams
	 */
	public static function formChangeSubmitButtonText(&$arResult, &$arParams)
	{
		// Меняем текст кнопки отправки формы
		if (strlen($arParams['SUBMIT_BUTTON_TEXT']))
			$arResult['arForm']['BUTTON'] = $arParams['SUBMIT_BUTTON_TEXT'];
	}

	/**
	 * для удаления пустых вопросов
	 * @param $arResult
	 * @param $arParams
	 */
	public static function formDeleteEmptyQuestions(&$arResult, &$arParams)
	{
		foreach ($arResult['QUESTIONS'] as $FIELD_SID => $arQuestion)
		{
			// Удаляем вопросы без ответов
			if (empty($arQuestion['STRUCTURE'])) unset($arResult['QUESTIONS'][$FIELD_SID]);
		}
	}

	/**
	 * для смены атрибутов полям для ввода в форме
	 * кастомизируется как надо для формы
	 * TODO: добавить правильные параметры, чтобы кастомизировать через них
	 * @param $arResult
	 * @param $arParams
	 */
	public static function formEditInputsHtml(&$arResult, &$arParams)
	{
		$arResult['FORM_HEADER'] = preg_replace('#(?<=\<form)(\s+)#i', '$1class="form-horizontal" ', $arResult['FORM_HEADER']);

		foreach ($arResult['QUESTIONS'] as $FIELD_SID => &$arQuestion)
		{
			$bQuestionWithOneAnswer = (
				(is_array($arResult['arAnswers'][$FIELD_SID]) && count($arResult['arAnswers'][$FIELD_SID])==1) ||
				(!is_array($arResult['arAnswers'][$FIELD_SID]) && $arResult['arQuestions'][$FIELD_SID] && $arResult['arQuestions'][$FIELD_SID]['ADDITIONAL'] == 'Y')
			);

			// добавляем placeholder и картинку к текстовому полю
			$dom = new \DOMDocument();
			@$dom->loadHTML('<?xml encoding="'.SITE_CHARSET.'" ?>' . $arQuestion['HTML_CODE']);
			$x = new \DOMXPath($dom);

			$nodes = $x->query('//input|//textarea|//select|//button');
			if ($nodes->length > 0) {
				foreach($nodes as $node) {
					// placeholder
					$node->setAttribute('autocomplete', 'off');
					//if ($bQuestionWithOneAnswer)
					//	$node->setAttribute('placeholder', strip_tags(trim($arQuestion['CAPTION'])));
					// классы
					$arClasses = Array();
					if (!in_array($node->getAttribute('type'), Array('file', 'checkbox', 'radio'))) $arClasses[] = 'form-control';
					// ошибка
					// if (is_array($arResult['FORM_ERRORS']) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS']))
					//	$arClasses[] = 'has-error';

					if (count($arClasses))
					{
						$oldValue = $node->getAttribute('class'); if (strlen($oldValue)) $oldValue .= ' ';
						$node->setAttribute('class', $oldValue . implode(' ', $arClasses));
					}

					if ( ($name = $node->getAttribute('name')) && !isset($arQuestion['FIRST_ANSWER_NAME'])) {
						$node->setAttribute('id', $name);
						$arQuestion['FIRST_ANSWER_NAME'] = $name;
					}

				}

				$arQuestion['HTML_CODE'] = \Tools\Snippets\Common::trimSavedDoc($dom->saveHtml());
			}


		}

		$arResult['REQUIRED_SIGN'] = '&nbsp;<span class="text-danger">*</span>';
	}

	/**
	 * для задания js параметров
	 * @param $arResult
	 * @param $arParams
	 * @param $obj
	 */
	public static function formJsParams(&$arResult, &$arParams, &$obj)
	{
		$arResult['JS_PARAMS'] = Array('VISUAL' => Array('ID' => $obj->GetEditAreaId('webform_'.$arResult['arForm']['ID'])));
	}
}