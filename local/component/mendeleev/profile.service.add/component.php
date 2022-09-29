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
if (in_array($arParams["RIGHT_SERVICE"], $arParams["USER"]["UF_EMPLOYEE_SECTION"]) || $arParams["USER"]["UF_TYPE"] == 1) {
    $arResult["DIRECTION"] = $this->getOrganizationDirection();
    $arResult["LIST_SERVICE"] = $this->getServiceList();
    $arResult["LIST_GI"] = $this->getAllGI();
    $arResult["LIST_KI"] = $this->getAllKI();
    $arResult["LIST_CITY"] = $this->getAllCity();
    $arResult["LIST_PRICE"] = $this->getAllPrice();

    if ($_POST["add_service"] && check_bitrix_sessid()) {
        $this->addService();
        LocalRedirect($arParams["URL"]["URL_TEMPLATES_SERVICE"]);
    }
}

//mpr($arResult , false);

$this->IncludeComponentTemplate();
