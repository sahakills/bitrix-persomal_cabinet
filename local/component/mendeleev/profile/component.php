<?php

if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Page\Asset;

Asset::getInstance()->addCss(SITE_TEMPLATE_PATH .'/assets/css/personal.css' , true);
CJSCore::Init();
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
//
$arResult['USER'] = $this->arUser;
$arResult['USER']['USER_TYPE'] = $this->getUserType();
$arAvailablePathUser = $this->availablePathUser($arResult['USER']['USER_TYPE']);
$arResult['PATH_TEMPLATE'] = $this->generateUrls($arAvailablePathUser);
//собираем данные по типу пользователя default organization employee
switch ($arResult['USER']['USER_TYPE']) {
    case "default":
        break;
    case "organization":
        $arResult["MENU_LINKS"] = $this->linkMenuIndexCheck($arAvailablePathUser);
        $arResult["ORGANIZATION"] = $this->getOrganizationByUser();
        break;
    case "employee":
        $arResult["MENU_LINKS"] = $this->linkMenuIndexCheck($arAvailablePathUser);
        $arResult['ORGANIZATION'] = $this->getOrganizationByUser();
        $arResult["SECTION"];
        break;
}


$this->IncludeComponentTemplate($arResult['PATH_TEMPLATE']['PAGE_NAME']);
