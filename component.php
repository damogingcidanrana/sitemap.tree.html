<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

CModule::IncludeModule("iblock");
CModule::IncludeModule("main");
global $APPLICATION;
$arIblocks = $arParams["IBLOCKS"];
$arExcludedFoldersParams = $arParams["EXCLUDED_FOLDERS"];

foreach ($arExcludedFoldersParams as $folder) {
	if(empty($folder)){continue;}
	$arExcludedFolders[] = trim($folder);
}

$arResult = getFoldersList($arExcludedFolders);

foreach($arIblocks as $Iblock){
	if ($Iblock["SECTIONS"]==="Y") {
		$sections = CIBlockSection::GetList(Array(),Array('IBLOCK_ID'=>$Iblock["ID"],'ACTIVE'=>'Y'),false,Array("NAME","SECTION_PAGE_URL"));
		while ($section = $sections->GetNext())
		{
			$element_name = $section['NAME'];
			$element_path = $section['SECTION_PAGE_URL'];
			if (strlen($arResult[$element_path]["NAME"])==0 && strlen($element_path)>0 && strlen($element_name)>0) {
				$arResult[$element_path]["PATH"] = $element_path;
				$arResult[$element_path]["NAME"] = $element_name;
			}	
		}
	}

	if ($Iblock["ELEMENTS"]==="Y") {
		$elements = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=> $Iblock["ID"], "ACTIVE" => "Y"), false, false, Array("NAME","DETAIL_PAGE_URL"));
		while ($element = $elements->GetNext())
		{
			$element_name = $element['NAME'];
			$element_path = $element['DETAIL_PAGE_URL'];
			if (strlen($arResult[$element_path]["NAME"])==0 && strlen($element_path)>0 && strlen($element_name)>0) {
				$arResult[$element_path]["PATH"] = $element_path;
				$arResult[$element_path]["NAME"] = $element_name;
			}	
		}
	}

}

function getFoldersList($arExcludedFolders) {
	$directory = $_SERVER["DOCUMENT_ROOT"];
	$root_dir = scandir($directory);
	foreach($root_dir as $dir){
		if($dir == "." || $dir == ".." || in_array($dir, $arExcludedFolders) || is_file($dir) || strpos($dir, ".") !== false)
		{
			continue;
		} else {
			foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($_SERVER["DOCUMENT_ROOT"]."/".$dir)) as $file) 
			{
				$full_pathname = $file->getPathname();
				if(strpos($full_pathname, "index.php") == false) {
					continue;
				} else {
					$dir_path = str_replace($_SERVER["DOCUMENT_ROOT"], "", str_replace("index.php", "", $full_pathname));
					$arFolders[$dir_path]["PATH"] = $dir_path;
					include_once str_replace("index.php", "", $full_pathname).".section.php";
					$arFolders[$dir_path]["NAME"] = $sSectionName;
				}
			}
		}
	}
 	return $arFolders;   
}
$this->IncludeComponentTemplate();
?>