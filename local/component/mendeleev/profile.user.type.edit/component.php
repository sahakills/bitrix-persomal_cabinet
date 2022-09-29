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
if ($_POST["user_change_email"] && check_bitrix_sessid()) {
    $arUpdate = $this->updateUserEmail();
    if ($arUpdate["UPDATE"]) {
        $arResult["UPDATE_EMAIL"] = "На новую почту отправлено письмо для подтверждения";
    } else {
        $arResult["ERROR_UPDATE_EMAIL"] = $arUpdate["ERROR_UPDATE_EMAIL"];
    }
}
if ($_POST["user_change_password"] && check_bitrix_sessid()) {
    $arUpdate = $this->updateUserPassword();
    if ($arUpdate["UPDATE"]) {
        $arResult["UPDATE_PASSWORD"] = "Ваш пароль изменен";
    } else {
        $arResult["ERROR_UPDATE_PASSWORD"] = $arUpdate["ERROR_UPDATE_PASSWORD"];
    }
}
$this->IncludeComponentTemplate();
