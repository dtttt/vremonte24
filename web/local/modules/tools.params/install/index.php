<?
IncludeModuleLangFile(__FILE__);

class tools_params extends CModule
{
	const MODULE_ID = 'tools.params';
	const BASE_CLASS = 'ToolsParams';
	var $MODULE_ID = 'tools.params';
	public $MODULE_VERSION;
	public $MODULE_VERSION_DATE;
	public $MODULE_DESCRIPTION;
	public $MODULE_NAME;
	public $MODULE_GROUP_RIGHTS = 'N';
	public $NEED_MAIN_VERSION = '';
	public $NEED_MODULES = array();

	public function __construct()
	{
		$arModuleVersion = array();
		include(dirname(__FILE__).'/version.php');
		if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion))
		{
			$this->MODULE_VERSION = $arModuleVersion['VERSION'];
			$this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
		}
		$this->PARTNER_NAME = '';
		$this->PARTNER_URI = '';
		$this->MODULE_NAME = GetMessage($this->MODULE_ID.'_MODULE_NAME');
		$this->MODULE_DESCRIPTION = GetMessage($this->MODULE_ID.'_MODULE_DESC');
	}

	public function DoInstall()
	{
		global $APPLICATION;
		if (is_array($this->NEED_MODULES) && !empty($this->NEED_MODULES))
			foreach ($this->NEED_MODULES as $module)
				if (!IsModuleInstalled($module)) {
					$APPLICATION->ThrowException(GetMessage($this->MODULE_ID.'_NEED_MODULES', array('#MODULE#' => $module)));
					return false;
				}
		if (strlen($this->NEED_MAIN_VERSION)<=0 || version_compare(SM_VERSION, $this->NEED_MAIN_VERSION)>=0)
		{
			Bitrix\Main\ModuleManager::registerModule($this->MODULE_ID);
			Bitrix\Main\EventManager::getInstance()->registerEventHandlerCompatible('main', 'OnBeforeProlog', $this->MODULE_ID, self::BASE_CLASS, 'OnBeforeProlog', -999);
		}
		else
		{
			$APPLICATION->ThrowException(GetMessage($this->MODULE_ID.'_NEED_RIGHT_VER', array('#NEED#' => $this->NEED_MAIN_VERSION)));
			return false;
		}
	}

	public function DoUninstall()
	{
		Bitrix\Main\EventManager::getInstance()->unRegisterEventHandler('main', 'OnBeforeProlog', $this->MODULE_ID, self::BASE_CLASS, 'OnBeforeProlog');
		Bitrix\Main\ModuleManager::unRegisterModule($this->MODULE_ID);
	}
}
?>
