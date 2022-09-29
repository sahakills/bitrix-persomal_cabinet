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
if ($_POST["AJAX_CALL"] == "Y" && check_bitrix_sessid() && $_POST['employee-edit']) {
    $APPLICATION->RestartBuffer();
    if ($this->upDateUser()) {
        $arResult["USER_UPDATE"] = "Y";
    } else {
        $arResult["USER_UPDATE_ERROR"] = "Ошибка при изменении сотрудника";
    }
}
if ($_POST["AJAX_CALL"] == "Y" && check_bitrix_sessid() && $_POST['add-new-employee']) {
    $APPLICATION->RestartBuffer();
    $arResult["SUCCESS_ADD_EMPLOYEE"] =  $this->addEmployee();
}
if ($arParams["ORGANIZATION"]["MODERATION"]) {
    $arResult["LIST_EMPLOYEE"] = $this->getEmployeeOrganization();
    $arResult["LIST_DIRECTION"] = $this->getPropretyUser("UF_EMPLOYEE_SECTION");
}
$this->IncludeComponentTemplate();
