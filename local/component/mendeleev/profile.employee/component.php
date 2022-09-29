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
//mpr($arParams , false);
if ($_POST["update-employee-info"] && check_bitrix_sessid()) {
    $arResult["UPDATE"] = $this->updateUserInfo();
    LocalRedirect($APPLICATION->GetCurPage());
}
$this->IncludeComponentTemplate();
