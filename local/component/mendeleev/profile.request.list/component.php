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
if (!$arParams["ORGANIZATION"]["MODERATION"]) {
    $arResult["ERROR"] = "Организация находится на модерации";
    if (in_array($arParams["RIGHT_USER"], $arParams["USER"]["UF_EMPLOYEE_SECTION"]) || $arParams["USER"]["UF_TYPE"] == 1) {

    } else {
        $arResult["ERROR"] = "Нет доступа";
    }
}
if (empty($arResult["ERROR"])) {
    $arResult["ITEMS"] = $this->getItems();
}

$this->IncludeComponentTemplate();
