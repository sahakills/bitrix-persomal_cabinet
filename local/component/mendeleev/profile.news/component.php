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
if (in_array($arParams["RIGHT_NEWS"] , $arParams["USER"]["UF_EMPLOYEE_SECTION"]) || $arParams["USER"]["UF_TYPE"] == 1) {
    if ($arParams["ORGANIZATION"]["MODERATION"]) {

        $arResult["LIST_SECTION"] = $this->getSectionList();
        foreach ($arResult["LIST_SECTION"] as $intKey => $arSection) {
            if ($arSection["ID"] == $arParams["SECTION_ID"]) {
                $arResult["LIST_TITLE"] = $arSection["NAME"];
                $arResult["LIST_TITLE_BTN"] = "Добавить " . $arSection["UF_TITLE_LIST"];
            }

        }
        $arResult["LINK_ADD"] = $this->linkAddItem($arParams["SECTION_ID"]);
        $templateNewsList = "";
        if (!empty($arParams["TEMPLATE_ITEM_LIST"])) {
            $templateNewsList = $arParams["TEMPLATE_ITEM_LIST"];
        }
        $arResult["TEMPLATE_ITEM_LIST"] = $templateNewsList;

    } else {
        $arError['MESSAGE'] = "Раздел будет доступен после проверки данных модератором";
    }
} else {
    $arError['MESSAGE'] = "Доступ закрыт";
}
if (!empty($arError)) {
    $arResult['ERROR'] = $arError;
}
$this->IncludeComponentTemplate();
