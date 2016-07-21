<?
namespace Tools\Params;

class SystemAuthForm extends Base
{
	public static function systemAuthForm()
	{
		$array = Array(
			"COMPONENT_TEMPLATE" => ".default",
			"FORGOT_PASSWORD_URL" => "",
			"PROFILE_URL" => "",
			"REGISTER_URL" => "",
			"SHOW_ERRORS" => "N",
			"FIELDS_BY_USER_GROUP" => array(
				"LEGAL" => array("WORK_PHONE", "WORK_COMPANY", "WORK_POSITION"),
				"INDIVIDUAL" => array("NAME", "PERSONAL_PHONE"),
			),
			"USER_FIELDS_BY_USER_GROUP" => Array(
				"LEGAL" => array("UF_WORK_INN", ),
				"INDIVIDUAL" => array(),
			),
			"REQUIRED_FIELDS_BY_USER_GROUP" => array(
				"LEGAL" => array("WORK_PHONE", "WORK_COMPANY", "WORK_POSITION"),
				"INDIVIDUAL" => array("NAME", "PERSONAL_PHONE"),
			),
			"REQUIRED_USER_FIELDS_BY_USER_GROUP" => array(
				"LEGAL" => array(),
				"INDIVIDUAL" => array(),
			)
		);
		return Common::glue($array, array(
			Common::profilePaths()
		));
	}
}