<?
namespace Tools\Snippets\Components;

class SystemPagenavigation
{
	private function __construct() {}

	public static function betterPagesCompare($a, $b, $k)
	{
		return $k == 1? $a > $b: $a < $b;
	}

	public static function betterPages(
		&$arResult,
		&$arParams,
		$arOptions = array(
			//Количество страниц до и после текущей страницы
			//$arOptions['range'] = 3
			//  ... 7 8 9 |10| 11 12 13 ...
			'range' => 2,
			//Страницы с начала
			//$arOptions['firstCount'] = 1
			//1 ... 7 8 9 |10| 11 12 13 ...
			'firstCount' => 1,
			//Страницы с конца
			//$arOptions['lastCount'] = 1
			//  ... 7 8 9 |10| 11 12 13 ... 20
			'lastCount' => 2,
			//Дополнительные страницы в начале
			//$arOptions['startExtra'] = 3, $arOptions['firstCount'] = 1
			// (|1|) 2 3 4 (5 6 7) ...
			'startExtra' => 2,
			//Дополнительные страницы в конце
			//$arOptions['endExtra'] = 4, $arOptions['lastCount'] = 1
			// ... (13 14 15 16) 17 18 19 (|20|)
			'endExtra' => 2,
		)
	) {
		if(!$arResult["NavShowAlways"])
		{
			if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
				return;
		}

		$arOptions += array(
			'range' => 2,
			'firstCount' => 1,
			'lastCount' => 2,
			'startExtra' => 2,
			'endExtra' => 2,
		);

		$NavPageCount = $arResult['NavPageCount'] <= 0? 1: (int)$arResult['NavPageCount'];
		if($arResult["bDescPageNumbering"] === true)
		{
			$firstPage = (int)$NavPageCount;
			$lastPage = 1;
			if ($firstPage<$lastPage) $firstPage = $lastPage;
			$k = -1;
		}
		else
		{
			$firstPage = 1;
			$lastPage = (int)$NavPageCount;
			if ($lastPage<$firstPage) $lastPage = $firstPage;
			$k = 1;
		}

		$first = $arResult["NavPageNomer"]-$k*$arOptions['range']; if (self::betterPagesCompare($first,$firstPage,-$k)) $first=$firstPage;
		$last = $arResult["NavPageNomer"]+$k*$arOptions['range']; if (self::betterPagesCompare($last,$lastPage,$k)) $last=$lastPage;


		for($i=$firstPage,$l=$i+$k*$arOptions['firstCount'],$l=self::betterPagesCompare($l,$lastPage,$k)?$lastPage:$l;$i!=$l;$i+=$k)
			$arResult["pages"][$i] = $i;
		if ((($arOptions['firstCount']+$arOptions['range'])<$NavPageCount) && self::betterPagesCompare(($firstPage-$k+$k*$arOptions['firstCount']+$k*$arOptions['startExtra']), $arResult["NavPageNomer"], $k))
			for($i=$firstPage+$k*$arOptions['firstCount']+$k*$arOptions['range'],$l=$i+$k*$arOptions['startExtra'],$l=self::betterPagesCompare($l-$k,$lastPage,$k)?$lastPage:$l;$i!=$l;$i+=$k)
				$arResult["pages"][$i] = $i;
		for($i=$first,$l=$last+$k;$i!=$l;$i+=$k)
			$arResult["pages"][$i] = $i;
		if ((($arOptions['lastCount']+$arOptions['range'])<$NavPageCount) && self::betterPagesCompare(($lastPage+$k-$k*$arOptions['lastCount']-$k*$arOptions['endExtra']), $arResult["NavPageNomer"], -$k))
			for($i=$lastPage-$k*$arOptions['lastCount']-$k*$arOptions['range'],$l=$i+$k*$arOptions['endExtra'],$l=self::betterPagesCompare($l+$k,$firstPage,-$k)?$firstPage:$l;$i!=$l;$i+=$k)//{
				/*	echo $lastPage.' '.$arOptions['lastCount'].' '.$arOptions['range'].'<br>';
					echo $i.' '.$l;;break;
				}*/
				$arResult["pages"][$i] = $i;
		for($i=$lastPage,$l=$i-$k*$arOptions['lastCount'],$l=self::betterPagesCompare($l,$firstPage,-$k)?$firstPage:$l;$i!=$l;$i-=$k)
			$arResult["pages"][$i] = $i;
		sort($arResult["pages"]);
		if ($arResult["bDescPageNumbering"] === true) $arResult["pages"] = array_reverse($arResult["pages"], true);

		$arResult['k'] = $k;
		$arResult['firstPage'] = $firstPage;
		$arResult['lastPage'] = $lastPage;
	}
}