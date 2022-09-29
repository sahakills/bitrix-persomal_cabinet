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
if ($arParams["ORGANIZATION"]["MODERATION"]) {
    $countRequest = $this->countElemetsRequst();
    if ($countRequest > 0 ) {
        foreach ($arParams["MENU_LINKS"] as &$arValue) {
            if ($arValue["SHOW_COUNT"] == true) {
                $arValue["COUNT"] = $countRequest;
            }
        }
    }
}
$this->IncludeComponentTemplate();
