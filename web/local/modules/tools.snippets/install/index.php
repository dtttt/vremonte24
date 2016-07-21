<?
IncludeModuleLangFile(__FILE__);
class tools_snippets extends CModule
{
	const MODULE_ID = 'tools.snippets';
	const BASE_CLASS = 'ToolsSnippets';
	var $MODULE_ID = 'tools.snippets';
	public $bNotOutput;
	public $MODULE_VERSION;
	public $MODULE_VERSION_DATE;
	public $MODULE_DESCRIPTION;
	public $MODULE_NAME;
	public $MODULE_GROUP_RIGHTS = 'N';
	public $NEED_MAIN_VERSION = '14.0.0';
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

		$this->holder = self::toolsGetHolder();
		$this->install_path = dirname(__FILE__);
		$this->namespace = preg_replace('#\.(?>.*)$#', '', $this->MODULE_ID);
		$this->module_relpath = $this->toolsGetModuleRelativePath();
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
			$this->InstallFiles();
			$this->InstallDB();
			$this->InstallEvents();
		}
		else
		{
			$APPLICATION->ThrowException(GetMessage($this->MODULE_ID.'_NEED_RIGHT_VER', array('#NEED#' => $this->NEED_MAIN_VERSION)));
			return false;
		}
	}

	public function DoUninstall()
	{
		$this->UnInstallFiles();
		$this->UnInstallDB();
		$this->UnInstallEvents();
	}

	public function InstallDB()
	{
		Bitrix\Main\ModuleManager::registerModule($this->MODULE_ID);
		Bitrix\Main\EventManager::getInstance()->registerEventHandlerCompatible('main', 'OnBeforeProlog', $this->MODULE_ID, self::BASE_CLASS, 'OnBeforeProlog');
		Bitrix\Main\EventManager::getInstance()->registerEventHandlerCompatible('main', 'OnAdminTabControlBegin', $this->MODULE_ID, 'ToolsSnippets\\Components\\AdvertisingBanner', 'OnAdminTabControlBegin');

		return true;
	}

	public function UnInstallDB()
	{
		Bitrix\Main\EventManager::getInstance()->unRegisterEventHandler('main', 'OnBeforeProlog', $this->MODULE_ID, self::BASE_CLASS, 'OnBeforeProlog');
		Bitrix\Main\EventManager::getInstance()->unRegisterEventHandler('main', 'OnAdminTabControlBegin', $this->MODULE_ID, 'ToolsSnippets\\Components\\AdvertisingBanner', 'OnAdminTabControlBegin');
		Bitrix\Main\ModuleManager::unRegisterModule($this->MODULE_ID);
		return true;
	}

	public function InstallEvents() { return true; }

	public function UnInstallEvents() { return true; }

	public function InstallFiles()
	{
		// создание файла .htaccess
		$this->toolsInstallHtaccess();
		// установка файлов-ссылок на файлы модуля
		$this->toolsInstallLinkFiles(Array());
		// установка компонентов
		$this->toolsInstallComponents();
		// установка контента модуля
		$this->toolsInstallContent(Array());

		return true;
	}

	public function UnInstallFiles()
	{
		// удаление файлов-ссылок на файлы модуля
		$this->toolsUnInstallLinkFiles();
		// удаление компонентов
		$this->toolsUnInstallComponents();
		// удаление контента модуля
		$this->toolsUnInstallContent(Array());
		return true;
	}

	private function toolsInstallHtaccess()
	{
		if ($this->holder == '/local')
			if (!file_exists($_SERVER['DOCUMENT_ROOT'].$this->holder.'/modules/.htaccess'))
			{
				@file_put_contents($_SERVER['DOCUMENT_ROOT'].$this->holder.'/modules/.htaccess', 'Deny from All');
				if (defined('BX_FILE_PERMISSIONS'))
					@chmod($_SERVER['DOCUMENT_ROOT'].$this->holder.'/modules/.htaccess', BX_FILE_PERMISSIONS);
			}
	}

	// установка ссылающихся файлов
	private function toolsInstallLinkFiles($dirs = array())
	{
		if ($this->module_relpath === false) return;
		foreach($dirs as $search_dir)
		{
			if (false === ($result = $this->toolsGetFileList($search_dir))) continue;

			if (!preg_match('#^admin/?#', $search_dir))
				CopyDirFiles(
					$_SERVER['DOCUMENT_ROOT'] . $this->module_relpath . '/' . $search_dir . '/',
					$_SERVER['DOCUMENT_ROOT'] . $this->holder . '/' . $search_dir . '/' . $this->MODULE_ID . '/',
					true, true
				);

			foreach($result[1] as $dir)
				CheckDirPath($result[2] . $dir);
			foreach($result[0] as &$file)
			{
				@file_put_contents($file['link'], "<?php\r\nrequire_once(\$_SERVER['DOCUMENT_ROOT'].\"{$file['orig_rel']}\");\r\n?>");
				if (defined('BX_FILE_PERMISSIONS'))
					@chmod($file['link'], BX_FILE_PERMISSIONS);
			}
		}
	}

	// удаление ссылающихся файлов
	private function toolsUnInstallLinkFiles($dirs = array())
	{
		if ($this->module_relpath === false) return;
		foreach($dirs as $search_dir)
		{
			if (false === ($result = $this->toolsGetFileList($search_dir))) continue;
			foreach($result[0] as &$file) @unlink($file['link']);

			foreach(array_reverse($result[1]) as $folder)
			{
				$dirname = $result[2] . $folder;
				$handle = @opendir($dirname);
				if (!$handle) continue;
				$folder_empty = true;
				while (false !== ($dir = @readdir($handle)))
				{
					if ($dir == '.' || $dir == '..') continue;
					$folder_empty = false; break;
				}
				@closedir($handle);
				if ($folder_empty) @rmdir($dirname);
			}
		}
	}

	// установка компонентов модуля
	private function toolsInstallComponents()
	{
		// Установка компонентов
		$base_dir = 'components';
		if (is_dir($this->install_path.'/'.$base_dir))
			CopyDirFiles($this->install_path.'/'.$base_dir.'/', $_SERVER['DOCUMENT_ROOT'].$this->holder.'/'.$base_dir.'/'.$this->namespace, true, true);
	}

	// удаление компонентов модуля
	private function toolsUnInstallComponents()
	{
		// удаление компонентов
		$base_dir = 'components';
		$dirname = $this->install_path.'/'.$base_dir.'/';
		$handle = @opendir($dirname);
		if ($handle) {
			while (false !== ($dir = @readdir($handle)))
			{
				if ($dir == '.' || $dir == '..') continue;
				if (is_dir($dirname.$dir) || is_file($dirname.$dir))
					DeleteDirFilesEx($this->holder.'/'.$base_dir.'/'.$this->namespace.'/'.$dir);
			}
			sleep(1);
		}

		// Дополнительно пробуем удалить внешние папки, если они пустые
		foreach(array($base_dir.'/'.$this->namespace, $base_dir) as $dir)
		{
			$dirname = $_SERVER['DOCUMENT_ROOT'].$this->holder.'/'.$dir.'/';
			$handle = @opendir($dirname);
			if (!$handle) continue; $folder_empty = true;
			while (false !== ($dir = @readdir($handle)))
			{
				if ($dir == '.' || $dir == '..') continue;
				$folder_empty = false;
				break;
			}
			@closedir($handle);
			if ($folder_empty) {@rmdir($dirname); sleep(1);}
			else break;
		}
	}

	// установка контента модуля
	private function toolsInstallContent($dirs = array())
	{
		// установка контента модуля
		foreach($dirs as $dir)
			if (is_dir($this->install_path.'/'.$dir))
				CopyDirFiles($this->install_path.'/'.$dir.'/', $_SERVER['DOCUMENT_ROOT'].$this->holder.'/'.$dir.'/'.$this->MODULE_ID.'/', true, true);
	}

	// удаление контента модуля
	private function toolsUnInstallContent($dirs = array())
	{
		foreach($dirs as $dir)
		{
			if (is_dir($this->holder.'/'.$dir.'/'.$this->MODULE_ID))
			{
				DeleteDirFilesEx($this->holder.'/'.$dir.'/'.$this->MODULE_ID);
				sleep(1);
			}
			// Дополнительно пробуем удалить внешнюю папку, если она пустая
			$dirname = $_SERVER['DOCUMENT_ROOT'].$this->holder.'/'.$dir.'/';
			$handle = @opendir($dirname);
			if (!$handle) continue; $folder_empty = true;
			while (false !== ($dir = @readdir($handle)))
			{
				if ($dir == '.' || $dir == '..') continue;
				$folder_empty = false;
				break;
			}
			@closedir($handle);
			if ($folder_empty) @rmdir($dirname);
		}
	}

	// Возвращает корневую папку модуля: /bitrix или /local
	public static function toolsGetHolder()
	{
		static $holder;
		if (!isset($holder))
			//                        ... /bitrix/modules/module./install/index.php
			$holder = strtolower(basename(dirname(dirname(dirname(dirname(__FILE__)))))) == 'local'? '/local': BX_ROOT;
		return $holder;
	}

	private function toolsGetModuleRelativePath()
	{
		$DOCUMENT_ROOT = rtrim(str_replace(array("\\", "//"), '/', $_SERVER['DOCUMENT_ROOT']), '/');
		$FILE = str_replace(array("\\", "//"), '/', __FILE__);
		if (strpos($FILE, $DOCUMENT_ROOT) !== 0) return false;

		$page_path = substr($FILE, strlen($DOCUMENT_ROOT));
		$path_parts = preg_split('#\/#', $page_path);
		$module_path = '';
		foreach($path_parts as &$path_part)
		{
			$module_path .= $path_part . '/';
			if ($path_part == $this->MODULE_ID) return $module_path;
		}
		return false;
	}

	private function toolsGetFileList($search_dir)
	{
		$search_dir_formatted = $search_dir . '/';

		if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $this->module_relpath . $search_dir_formatted)) return false;

		$in_admin = preg_match('#^admin/?#', $search_dir);
		$holder = $search_dir == 'admin'? BX_ROOT: $this->holder;
		$files = array();
		$folders = array($search_dir_formatted);
		$link_folders = array($search_dir_formatted . ($in_admin ? '' : $this->MODULE_ID . '/') );
		$folder = reset($folders);
		do {
			$handle = @opendir($_SERVER['DOCUMENT_ROOT'] . $this->module_relpath . $folder);
			if (!$handle) continue;
			while (false !== ($dir = @readdir($handle)))
			{
				if ($dir == '.' || $dir == '..') continue;
				if ($search_dir == 'admin' && $dir == 'menu.php') continue;
				$relpath = $this->module_relpath . $folder . $dir;
				$fullpath = $_SERVER['DOCUMENT_ROOT'] . $relpath;
				if (is_dir($fullpath))
				{
					$folders[] = $folder . $dir . '/';
					$link_folders[] = $link_folders[key($folders)] . $dir . '/';
					continue;
				}
				if (is_file($fullpath) && strtolower(pathinfo($dir, PATHINFO_EXTENSION)) == 'php')
					$files[] = array('orig_rel' => $relpath, 'link' => $_SERVER['DOCUMENT_ROOT'] . $holder . '/' . $link_folders[ key($folders) ] . $dir);
			}
			@closedir($handle);
		} while (false !== ($folder = next($folders)));

		if (!$in_admin)
			array_unshift($link_folders, $search_dir_formatted);
		return array($files, $link_folders, $_SERVER['DOCUMENT_ROOT'] . $holder . '/');
	}
}