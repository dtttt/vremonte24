<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(!empty($arResult)):?>
	<?
	$strReturn = '';
	$strReturn .= '<ul class="breadcrumb">' . PHP_EOL;

	foreach($arResult as $arItem)
	{
		$strReturn .= '<li><a href="'.$arItem['LINK'].'">'.$arItem['TITLE'].'</a></li>' . PHP_EOL;
	}
	$strReturn .= '</ul>' . PHP_EOL;
	return $strReturn;
	?>
<?endif?>
