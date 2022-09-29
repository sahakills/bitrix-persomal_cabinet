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
if ($_GET["CHECKWORD"]) {
    $arResult = $this->changeEmail($_GET["CHECKWORD"]);
}
if ($_POST["CHECKWORD"] && $_POST["update_email"] && check_bitrix_sessid()) {
    $arResult = $this->changeEmail($_POST["CHECKWORD"]);
}

$this->IncludeComponentTemplate();
