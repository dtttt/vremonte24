<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<div class="vote-points" id="<?=$arResult['jsParams']['visual']['id']?>">
	<div class="prefix">Оценка</div>
	<div class="stars">
		<?for($i = 1; $i <= $arParams['MAX_VOTE']; ++$i):?>
			<?if ($i <= ceil($arResult['votesValue'])):?>
				<div class="active"></div>
			<?else:?>
				<div></div>
			<?endif?>
		<?endfor?>
	</div>
	<?if ($arParams['SHOW_RATING'] == 'Y'):?>
		<div class="suffix"><?=$arResult['votesValue']?></div>
	<?endif?>
</div>