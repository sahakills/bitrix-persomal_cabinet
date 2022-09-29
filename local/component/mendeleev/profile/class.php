<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

CModule::IncludeModule("iblock");

class ProfileMain extends CBitrixComponent{

    public $arUser;

    public function __construct($component = null)
    {
        parent::__construct($component);
        $this->arUser = $this->getUserFields();
    }

    public function getUserFields() {
        global $USER;
        return CUser::GetByID($USER->GetID())->Fetch();
    }

    public function getUserType() {
        $arUserField = $this->arUser['UF_TYPE'];
        return $this->arParams['USER_TYPE'][$arUserField];

    }

    public function availablePathUser ($strUserType ) {
        return $this->arParams['SEF_URL_TEMPLATES'][$strUserType];
    }

    public function generateUrls($arUrlsTemplate) {
        global $APPLICATION;
        $arResult = array();
        $arUrlPath = array();

        $arDefaultVariableAliases404 = Array();
        $arVariables = array();
        $arDefaultVariableAliases = Array(
            "SERVICE_ID" => "SERVICE_ID",
            "ELEMENT_ID" => "ELEMENT_ID",
            "SECTION_ID" => "SECTION_ID"
        );
        $arComponentVariables = array(
            "SERVICE_ID",
            "ELEMENT_ID",
            "SECTION_ID"
        );
        $arUrlsTemplates = array();
        foreach ($arUrlsTemplate as $key => $value) {
            $arUrlsTemplates[$key] = $value["URL"];
        }
//        mpr($arUrlsTemplates , false);
        $arDefaultUrlTemplates404 = $arUrlsTemplates;
        $arUrlTemplates = CComponentEngine::MakeComponentUrlTemplates($arUrlsTemplates, $arUrlsTemplates);

        $arVariableAliases = CComponentEngine::MakeComponentVariableAliases($arDefaultVariableAliases404, $arUrlsTemplates);

        $componentPage = CComponentEngine::ParseComponentPath($this->arParams["SEF_FOLDER"], $arUrlTemplates, $arVariables);

        CComponentEngine::InitComponentVariables($componentPage, $arComponentVariables, $arVariableAliases, $arVariables);

        foreach ($arUrlTemplates as $url => $value)
        {
            if (empty($arUrlTemplates[$url]))
            {
                $arUrlPath["URL_TEMPLATES_".mb_strtoupper($url)] = $this->arParams["SEF_FOLDER"].$arUrlsTemplates[$url];
            }
            elseif (mb_substr($arUrlTemplates[$url], 0, 1) == "/" || mb_substr($arUrlTemplates[$url], 0, 4) == "https")
                $arUrlPath["URL_TEMPLATES_".mb_strtoupper($url)] = $arUrlTemplates[$url];
            else
                $arUrlPath["URL_TEMPLATES_".mb_strtoupper($url)] = $this->arParams["SEF_FOLDER"].$arUrlTemplates[$url];
        }
        if ((empty($componentPage) || $componentPage == "index") && !empty($_REQUEST["PAGE_NAME"]))
        {
            $arVariableAliases = CComponentEngine::MakeComponentVariableAliases($arDefaultVariableAliases, array());
            CComponentEngine::InitComponentVariables(false, $arComponentVariables, $arVariableAliases, $arVariables);
        }
        if (!empty($arVariables["PAGE_NAME"]))
        {
            $componentPage = mb_strtolower($arVariables["PAGE_NAME"]);
        }
        //устанавливаем 404
        $bFounded = false;
        if ($componentPage && array_key_exists($componentPage, $arDefaultUrlTemplates404)) {
            $bFounded = true;
        } else {
            $componentPage = "index";
        }
        $arResult["PAGE_NAME"] = $componentPage;

        if (!$bFounded)
        {
            $folder404 = str_replace("\\", "/", $this->arParams["SEF_FOLDER"]);

            if ($folder404 != "/")
                $folder404 = "/".trim($folder404, "/ \t\n\r\0\x0B")."/";
            if (mb_substr($folder404, -1) == "/")
                $folder404 .= "index.php";

            if($folder404 != $APPLICATION->GetCurPage(true))
                CHTTP::SetStatus("404 Not Found");


        }
        $arResult = array_merge($arResult , $arUrlPath , $arVariables);
        return $arResult;
    }

    public function getOrganizationByUser() {
        $arResult = array();
        $rsResult = CIBlockElement::GetList(
            array(
                "id" => "acs"
            ),
            array(
                "IBLOCK_ID" => $this->arParams['IBLOCK_ORGANIZATION'],
//                $arUserPropertySearch
                "PROPERTY_USER_EMPLOYEE" => $this->arUser['ID']
            )
        );
        while($objElement = $rsResult->GetNextElement()) {
            $arElement = array();
            if ($objElement) {
                $arElement = $objElement->fields;
                $arElement['PROPERTY'] = $objElement->GetProperties();
                if (!empty($arElement["PROPERTY"]["INFO_REG_PHOTO"]["VALUE"])) {
                    $arElement["PROPERTY"]["INFO_REG_PHOTO"]["VALUE"] = CFile::GetFileArray($arElement["PROPERTY"]["INFO_REG_PHOTO"]["VALUE"]);
                } else {
                    $arElement["PROPERTY"]["INFO_REG_PHOTO"]["VALUE"] = false;
                }
                if ($objElement->fields['ACTIVE'] == 'Y') {
                    $arElement['MODERATION'] = true;
                } else {
                    $arElement['MODERATION'] = false;
                }
            }
            $arResult = $arElement;
        }
        if (!empty($arResult)) {
            return $arResult;
        } else {
            return false;
        }
    }



    public function getElementsIblock($idOrganization , $IBLOCK_PARAM , $strCodeSearchProp = false) {
        $arResult = array();
        $arFields["IBLOCK_ID"] = $IBLOCK_PARAM;
        if ($strCodeSearchProp) {
            $arFields["PROPERTY_".$strCodeSearchProp] = $idOrganization;
        }
        $rsResult = CIBlockElement::GetList(
            array(),
            $arFields
        );
        while($arElement = $rsResult->Fetch()) {
            if ($arElement) {
                $arResult[] = $arElement;
            }
        }
        if (!empty($arResult)) {
            return $arResult;
        } else {
            return false;
        }
    }
    public function linkMenuIndexCheck ($arAvailablePathUser) {
        global $APPLICATION;
        $arResult = array();
        foreach ($arAvailablePathUser as $strKey => $arValue) {
            if ($arValue["MENU"]) {
                $arValue["URL"] = $this->arParams["SEF_FOLDER"].$arValue["URL"];
                if ($arValue["URL"] == $APPLICATION->GetCurDir()) {
                    $arValue["SELECTED"] = true;
                }
                $arResult[] = $arValue;
            }
        }
        if ($this->arUser["UF_TYPE"] == 2 ) {
            foreach ($arResult as $strKey => $arValue) {
                if ($arValue["USER_SECTION"] && !in_array($arValue["USER_SECTION"] , $this->arUser["UF_EMPLOYEE_SECTION"])) {
                    unset($arResult[$strKey]);
                }
            }
        }
        return $arResult;
    }
}