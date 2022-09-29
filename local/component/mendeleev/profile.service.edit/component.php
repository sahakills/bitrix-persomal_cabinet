<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

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
if (in_array($arParams["RIGHT_SERVICE"], $arParams["USER"]["UF_EMPLOYEE_SECTION"]) || $arParams["USER"]["UF_TYPE"] == 1) {
    $arParams["ORGANIZATION"]["PROPERTY"]["SERVICE"]["VALUE"] = $this->mapArray();
    $arResult["CURRENT_PROP"] = $this->getCurrentProp();
    $arResult["DIRECTION"] = $this->getOrganizationDirection();
    //TODO:: можно сделать адекватно на фронте
    $arResult["LIST_SERVICE"] = $this->getServiceList();
    $arResult["LIST_GI"] = $this->getAllGI();
    $arResult["LIST_KI"] = $this->getAllKI();
    $arResult["LIST_CITY"] = $this->getAllCity();
    $arResult["LIST_PRICE"] = $this->getAllPrice();
    $arResult["SELECTED_LIST_GI"] = array();
    foreach ($arResult["LIST_GI"] as $arValue) {
        if (in_array($arValue["ID"], $arResult["CURRENT_PROP"][2])) {
            $arResult["SELECTED_LIST_GI"][] = $arValue["UF_HL_NAME_PROP"];
        }
    }
    $arResult["SELECTED_LIST_KI"] = array();
    foreach ($arResult["LIST_KI"] as $arValue) {
        if (in_array($arValue["ID"], $arResult["CURRENT_PROP"][4])) {
            $arResult["SELECTED_LIST_KI"][] = $arValue["UF_HL_PROPACCESS"];
        }
    }

    $arResult["SELECTED_LIST_CITY"] = array();
    foreach ($arResult["LIST_CITY"] as $arValue) {
        if (in_array($arValue["ID"], $arResult["CURRENT_PROP"][6])) {
            $arResult["SELECTED_LIST_CITY"][] = $arValue["NAME"];
        }
    }
    if ($_POST["update_service"] && check_bitrix_sessid()) {
        $this->updateProperty();
    }
    if ($_POST["services-button-delete"] && check_bitrix_sessid()) {
        $this->deleteProperty();
    }

    if (!$arResult["CURRENT_PROP"]) {
        $arError["MESSAGE"] = "Услуга не найдена";
    }
} else {
    $arError['MESSAGE'] = "Доступ закрыт";
}

if (!empty($arError)) {
    $arResult['ERROR'] = $arError;
}
//mpr($arParams, false);
//mpr($arResult, false);
$this->IncludeComponentTemplate();
