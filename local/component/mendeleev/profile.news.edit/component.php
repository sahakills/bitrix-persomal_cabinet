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

if (in_array($arParams["RIGHT_NEWS"] , $arParams["USER"]["UF_EMPLOYEE_SECTION"]) || $arParams["USER"]["UF_TYPE"] == 1) {
    $arResult = $this->getElement();
    $strTemplate = "";
    if ($arResult) {
        $arInfo["SECTION_INFO"] = $this->getSectionInfo($arParams["URL"]["SECTION_ID"]);
        $strTemplate = $arInfo["SECTION_INFO"]["TEMPLATE"];
        if ($arInfo["SECTION_INFO"]["TEMPLATE"]) {
            $strTemplate = $arInfo["SECTION_INFO"]["TEMPLATE"];
        }
        if( !empty($_POST["add-elements"]) && check_bitrix_sessid()) {
            $rsResultAdd = $this->editItems($arInfo["SECTION_INFO"]["IBLOCK_ID"] , $arInfo["SECTION_INFO"]["ID"]);
            LocalRedirect($arInfo["SECTION_INFO"]["LINK_BACK"]);
        } else {
            $arResult = $this->getElement();
            $arResult["PROP_LIST_TAG"] = $this->getPropListTag();
        }
        $arResult["LINK_BACK"] = $arInfo["SECTION_INFO"]["LINK_BACK"];
    } else {
        $strTemplate = "none";
    }

    $this->IncludeComponentTemplate($strTemplate);
}
