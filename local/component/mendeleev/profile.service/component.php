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
$arError = array();
if (in_array($arParams["RIGHT_SERVICE"] , $arParams["USER"]["UF_EMPLOYEE_SECTION"]) || $arParams["USER"]["UF_TYPE"] == 1) {

    if ($arParams["ORGANIZATION"]["MODERATION"]) {

        if (!empty($arParams["ORGANIZATION"]["PROPERTY"]["SERVICE"]["VALUE"])) {
            $arResult["ORGANIZATION"] = $arParams["ORGANIZATION"];
            $arResult["ORGANIZATION"]['SERVICE_LIST'] = $this->getServiceList();
        }
    } else {
        $arError['MESSAGE'] = "Раздел будет доступен после проверки данных модератором";
    }

} else {
    $arError['MESSAGE'] = "Доступ закрыт";
}

if (!empty($arError)) {
    $arResult['ERROR'] = $arError;
}
//mpr($arResult , false);
$this->IncludeComponentTemplate();