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
    $arResult["SECTION_INFO"] = $this->getSectionInfo($arParams["URL"]["SECTION_ID"]);
    $strTemplate = "";
    if ($arResult["SECTION_INFO"]["TEMPLATE"]) {
        $strTemplate = $arResult["SECTION_INFO"]["TEMPLATE"];
    }
    $arResult["LIST_SECTION"] = $this->getSectionList();
    $arResult["PROP_LIST_TAG"] = $this->getPropListTag();

    if( $_POST["add-elements"] && check_bitrix_sessid()) {
        if ($arResult["SECTION_INFO"]) {
            $rsResultAdd =  $this->addItems($arResult["SECTION_INFO"]["IBLOCK_ID"] , $arResult["SECTION_INFO"]["ID"]);
            if ($rsResultAdd) {
                $arResult["SUCCESS"] = "Материал добавлен на сайт";
            } else {
                $arResult["ERROR"] = "Произошла ошибка при добавлении материала";
            }
        }
    }
//    mpr($arResult , false);
    $this->IncludeComponentTemplate($strTemplate);

}

