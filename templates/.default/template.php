<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?
$data_path=array();
foreach($arResult as $key=>$arr){
  $data_path[$key]=$arr['PATH'];
}
array_multisort($data_path, SORT_STRING, $arResult);
$prev=array();
$prev_el = 'http://';
$no_first = 0;
$result = '<ul><li><a href="/">Главная</a></li>';
$start_el = reset($arResult);
$next_el = reset($arResult);
foreach($arResult as $root => $arFolder){
	$next_el = current($arResult);
	if (strpos($arFolder["PATH"],$prev_el)===0) {
		array_push($prev,$prev_el);
		$no_first = 0;
	}
	if (count($prev)>0) {
		$prev_el = $prev[count($prev)-1];
		if ($no_first==0) {
			$result.='<ul>';
		} else {
			$result.='</li>';
		}
		$result.='<li><a href="'.$arFolder["PATH"].'">'.$arFolder["NAME"].'</a>';
		$no_first++;
		$ind = count($prev);
		while($ind){
			if (strpos($next_el["PATH"],$prev_el)===false){
				$result.= '</li></ul>';
				array_pop($prev);
				if (count($prev)>0) {
					$prev_el = $prev[count($prev)-1];
				} else {
					$ind = false;
				}
			} else {
				$ind = false;
			}
		}
	} else {
		if($arFolder!=$start_el) {
			$result.= '</li>';
		}
		$result.='<li><a href="'.$arFolder["PATH"].'">'.$arFolder["NAME"].'</a>';
	}
	$prev_el = $arFolder["PATH"];
}
$result.='</li>';
echo $result;
?>