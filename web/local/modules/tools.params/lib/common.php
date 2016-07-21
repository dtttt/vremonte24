<?
namespace Tools\Params;

class Common extends Base
{
	public static function glue($rewrites = null, $adds = null, $removes = null)
	{
		$array = array();
		if (is_array($rewrites))
			foreach($rewrites as $rewrite)
				if (is_array($rewrite))
					$array = array_merge($array, $rewrite);

		if (is_array($adds))
			foreach($adds as $add)
				if (is_array($add))
				$array += $add;

		if (is_array($removes))
			foreach($removes as $remove)
				if (is_array($remove))
					foreach($remove as $key)
						if (isset($array[$key]))
							unset($array[$key]);

		return $array;
	}

	public static function cache($key = NULL)
	{
		$array = Array(
			'CACHE_TYPE' => 'A',
			'CACHE_TIME' => '2592000',
			'CACHE_FILTER' => 'N',
			'CACHE_GROUPS' => 'Y',
		);
		if ($key !== NULL)
		{
			return $array[$key];
		}
		else
		{
			return $array;
		}
	}

	public static function disableAjax()
	{
		return Array(
			'AJAX_MODE' => 'N',
			'AJAX_OPTION_SHADOW' => 'N',
			'AJAX_OPTION_JUMP' => 'N',
			'AJAX_OPTION_STYLE' => 'N',
			'AJAX_OPTION_HISTORY' => 'N',
		);
	}

	public static function enableAjax()
	{
		return Array(
			'AJAX_MODE' => 'Y',
			'AJAX_OPTION_SHADOW' => 'N',
			'AJAX_OPTION_JUMP' => 'N',
			'AJAX_OPTION_STYLE' => 'N',
			'AJAX_OPTION_HISTORY' => 'N',
		);
	}

	public static function show404()
	{
		return Array(
			"FILE_404" => "",
			"MESSAGE_404" => "",
			"SET_STATUS_404" => "Y",
			"SHOW_404" => "Y",
		);
	}

	public static function hide404()
	{
		return Array(
			"SET_STATUS_404" => "N",
			"SHOW_404" => "N",
		);
	}

	public static function paths()
	{
		return array(
			"PATH_TO_AUTH" => "/auth/",
			"PATH_TO_BASKET" => "/cart/",
			"PATH_TO_PAYMENT" => "/purchase/payment/",
			"PATH_TO_PERSONAL" => "/profile/",
			"PATH_TO_PROFILE" => "/profile/",
			"PATH_TO_ORDER" => "/purchase/",
			"PATH_TO_REGISTER" => "/register/",
		);
	}

	public static function profilePaths()
	{
		return array(
			"AUTH_URL" => "/auth/",
			"CHANGE_PASSWORD_URL" => "/recover/change/",
			"FORGOT_PASSWORD_URL" => "/recover/",
			"PROFILE_URL" => "/profile/",
			"REGISTER_URL" => "/register/",
			"CONFIRM_REGISTER_URL" => "/register/confirm/"
		);
	}

	public static function disableMeta()
	{
		return array(
			"SET_TITLE" => "N",
			"SET_BROWSER_TITLE" => "N",
			"SET_META_KEYWORDS" => "N",
			"SET_META_DESCRIPTION" => "N",
		);
	}

	public static function excludeBreadcrumbs()
	{
		return array(
			"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
			"ADD_SECTIONS_CHAIN" => "N",
		);
	}
}