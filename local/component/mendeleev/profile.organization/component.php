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

$arResult["ORGANIZATION_DIRECTION"] = $this->getOrganizationSection();
if ($arResult["ORGANIZATION_DIRECTION"]) {
    foreach ($arResult["ORGANIZATION_DIRECTION"] as $intValue) {
        $arCategory = $this->getParentCategory($intValue);
        if (!in_array($arCategory["ID"] , $arResult["ORGANIZATION_CATEGORY"])) {
            $arResult["ORGANIZATION_CATEGORY"][] = $arCategory["ID"];
        }
    }
    if (!empty($arResult["ORGANIZATION_CATEGORY"])) {
        $arResult["LIST_DIRECTION"] = $this->getListDirections($arResult["ORGANIZATION_CATEGORY"]);
        foreach ($arResult["LIST_DIRECTION"] as &$arValue) {
            if (in_array($arValue["ID"], $arResult["ORGANIZATION_DIRECTION"])) {
                $arValue["SELECTED"] = true;
                $arItem["NAME"] = $arValue["NAME"];
                $arItem["ID"] = $arValue["ID"];
                $arResult["CURRENT_DIRECTION"][] = $arItem;
            }
        }
    }
}
$arResult["LIST_CATEGORY"] = $this->getListCategory();
if ($_POST["AJAX_CALL"] && check_bitrix_sessid()) {
    $APPLICATION->RestartBuffer();
    $this->updateOrganization();
    //обновляем инфу организации т.к. до этого оно приходило через параметр
    $arParams["ORGANIZATION"] =  $this->getOrganizationByUser();
    $arResult["UPDATE_INFO"] = true;
}

$this->IncludeComponentTemplate();
