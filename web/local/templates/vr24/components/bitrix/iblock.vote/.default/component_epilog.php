<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
Tools\Vr24\IblockVote::componentEpilogJsParams($arResult, $arParams, $this);?>
<script type="text/javascript">
    var <?=$arResult['jsParams']['visual']['id']?> = new CT_BIV(<?=CUtil::PhpToJSObject($arResult['jsParams'], false, true, true);?>);
</script>