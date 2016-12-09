<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arCurrentValues */

CModule::IncludeModule("iblock");

$arIBlock = array();
$rsIBlock = CIBlock::GetList(array("sort" => "asc"), array("TYPE" => $arCurrentValues["IBLOCK_TYPE"], "ACTIVE"=>"Y"));
while($arr=$rsIBlock->Fetch()){
	$arIBlock[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];
}


$arComponentParameters = array(
	"PARAMETERS" => array(
		"IBLOCKS" => Array(
			"PARENT" => "BASE",
			"NAME" => "Выберите инфоблоки, элементы которых попадут в карту сайта",
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"VALUES" => $arIBlock,
			"DEFAULT" => ''
		),
		"EXCLUDED_FOLDERS" => Array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => "Укажите папки, которые не будут участвовать при построении карты сайта",
			"TYPE" => "STRING",
			"MULTIPLE" => "Y",
			"DEFAULT" => array(0=>"bitrix",1=>"upload",2=>"search",3=>"cgi-bin",4=>"images",),
		),
	),
);
?>