<?
namespace Tools\Vr24;
IncludeModuleLangFile(__FILE__);

class Common extends Base
{
    private static function stat($IBLOCK_ID, $MESS)
    {
        $cache_part = $IBLOCK_ID;
        $cache = new \Tools\Snippets\Cache(\Tools\Params\Common::cache('CACHE_TIME'), $cache_part."|".__NAMESPACE__ . '|' . __CLASS__ . '|' . __FUNCTION__);

        if (!$cache->get() && \CModule::IncludeModule('iblock'))
        {
            $cache->vars['COUNT'] = \CIBlockElement::GetList(array(),array('ACTIVE' => 'Y', 'IBLOCK_ID' => $IBLOCK_ID),array());
            $cache->set('iblock_id_'.$IBLOCK_ID);
        }
        echo
            '<div class="vsego-value">' , $cache->vars['COUNT'].'</div>' , PHP_EOL ,
            '<div class="vsego-title">' ,
            GetMessage(str_replace(
                '%s%',
                \Tools\Snippets\Common::declension($cache->vars['COUNT']),
                $MESS
            )),
            '</div>' , PHP_EOL;
    }
    
    public static function statInstructions()
    {
        self::stat(5, 'tools.vr24_INSTRUCTIONS_%s%');
    }

    public static function statParts()
    {
        self::stat(6, 'tools.vr24_PARTS_%s%');
    }

    public static function statAnswers()
    {
        self::stat(7, 'tools.vr24_ANSWERS_%s%');
    }
}