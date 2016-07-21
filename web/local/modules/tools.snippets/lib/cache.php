<?
namespace Tools\Snippets;

/**
 * Класс для упрощения работы с кешем
 * Как работать:
 * $cache = new \Tools\Snippets\Cache($cache_time, $cache_id_suffix);
 * if (!$cache->get()) {
 * 	$cache->vars = ...;
 * 	$cache->set((array|string)<теги управлемого кеша>);
 * 	// теги управляемого кеша:
 * 	// iblock_id_<IBLOCK_ID> - кеш очищается при изменении любого элемента указанного инфоблока
 * 	// список из остальных тегов не нашел, так что
 *  // другие теги можно искать поисковиком в папке bitrix по словам:
 * 	// $CACHE_MANAGER->RegisterTag, $CACHE_MANAGER->ClearByTag,
 * 	// $GLOBALS['CACHE_MANAGER']->RegisterTag, $GLOBALS['CACHE_MANAGER']->ClearByTag,
 * 	// $GLOBALS["CACHE_MANAGER"]->RegisterTag, $GLOBALS["CACHE_MANAGER"]->ClearByTag
 * }
 * [$cache->vars использование]
 *
 * Class Cache
 * @package Tools\Snippets
 */
class Cache
{
	private $cache_time;
	private $cache_id;
	private $cache_path;
	private $obj;
	public $vars;

	/**
	 *
	 * @param null $cache_time - время кеширования, если не указывать, возмется значение CACHED_b_site_template из bitrix/php_interface/dbconn.php
	 * @param null $cache_id_suffix - окончание для идентификатора кеша. начало идентификатора: id сайта + id языка + id шаблона сайта
	 * @param bool $cache_id_full - $cache_id_suffix становится полным идентификатором кеша
	 */
	public function __construct($cache_time = null, $cache_id_suffix = null, $cache_id_full = false)
	{
		if ($cache_time === null)
			$cache_time = (int)@constant('CACHED_b_site_template');
		$this->cache_time = $cache_time;

		if ($cache_id_full && strlen($cache_id_suffix)) {
			$this->cache_id = $cache_id_suffix;
		} else {
			if ($cache_id_suffix === null)
				$cache_id_suffix = $GLOBALS['APPLICATION']->GetCurPage();
			$this->cache_id = SITE_ID . '|' . LANGUAGE_ID . (defined('SITE_TEMPLATE_ID') ? '|' . SITE_TEMPLATE_ID : '') . '|' . $cache_id_suffix;
		}

		$this->cache_path = $this->getCachePath($cache_id_suffix);

		$this->obj = new \CPHPCache();
		$this->vars = array();
	}

	/**
	 * Получение кеша
	 * @return bool
	 */
	public function get()
	{
		if ($this->cache_time > 0)
		{
			if ($this->obj->InitCache($this->cache_time, $this->cache_id, $this->cache_path))
			{
				$this->vars = $this->obj->GetVars();
				return true;
			}

		}
	}

	/**
	 * Запись в кеш
	 * @param bool $tags
	 */
	public function set()
	{
		if ($this->cache_time > 0)
		{
			$tags = Array();
			foreach(func_get_args() as $arg) {
				if (is_array($arg) && count($arg))
					$tags = array_merge($tags, $arg);
				elseif (!is_array($arg) && strlen($arg))
					$tags[] = $arg;
			}
			if (count($tags) && defined('BX_COMP_MANAGED_CACHE'))
			{
				// Установка тегов для управляемого кеширования
				global $CACHE_MANAGER;
				$CACHE_MANAGER->StartTagCache($this->cache_path);
				foreach($tags as &$tag)
					$CACHE_MANAGER->RegisterTag($tag);
				$CACHE_MANAGER->EndTagCache();
			}
			$this->obj->StartDataCache($this->cache_time, $this->cache_id, $this->cache_path);
			$this->obj->EndDataCache($this->vars);
		}
	}

	/**
	 * Генерация пути в хранилище кеша
	 * По аналогии с @see ManagedCache::getCompCachePath
	 * @param $id - если не указать, путь сформируется на основе текущей страницы
	 * @return string
	 */
	private function getCachePath($id)
	{
		global $APPLICATION, $BX_STATE;

		$id = md5($id);
		$subdir = substr($id, 0, 3);

		if ($BX_STATE === 'WA')
		{
			$salt = \Bitrix\Main\Data\Cache::getSalt();
		}
		else
		{
			$salt = '/'.substr(md5($BX_STATE), 0, 3);
		}

		$id = '/legacy_cache/' . SITE_ID . '/' . (strlen($subdir)? $subdir . '/':'') . $id . $salt;
		return $id;
	}
}
