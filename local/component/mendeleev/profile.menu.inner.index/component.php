<?php
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();

/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
$strCurDir = $APPLICATION->GetCurDir();
foreach ($arParams["AR_URL"] as $key => &$arValue) {
    if($arValue["URL"] == $strCurDir) {
        $arValue["SELECT"] = true;
    } else {
        $arValue["SELECT"] = false;
    }
}
$arResult["LIST_SECTION"] = $arParams["AR_URL"];
$this->IncludeComponentTemplate();
