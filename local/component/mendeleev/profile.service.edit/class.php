<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Loader;
CModule::IncludeModule("iblock");

class ProfileServiceEdit extends CBitrixComponent
{
    public function mapArray() {
        $arResult = array();
        foreach ($this->arParams["ORGANIZATION"]["PROPERTY"]["SERVICE"]["VALUE"] as $intKey => $arValue) {
            $arValue["XML_ID"] = $this->arParams["ORGANIZATION"]["PROPERTY"]["SERVICE"]["PROPERTY_VALUE_ID"][$intKey];
            $arResult[] = $arValue;
        }

        return $arResult;
    }

    public function getOrganizationDirection() {
        $arResult = array();
        $rsResult = CIBlockElement::GetElementGroups(
            $this->arParams["ORGANIZATION"]["ID"],
            true,
            array(
                "ID",
                "NAME"
            )
        );
        while($arElement = $rsResult->Fetch()) {
            $arResult[] = $arElement;
        }
        return $arResult;
    }

    public function getServiceList() {
        $arResult = array();
        $rsElements = CIBlockElement::GetList(
            array(
                "id" => "acs"
            ),
            array(
                "IBLOCK_ID" => 30,
                "ACTIVE" => "Y",
                "PROPERTY_SERVICE_ITEM" => $this->arParams["URL"]["SECTION_ID"]
            ),
            false,
            false,
            array(
                "ID",
                "NAME"
            )
        );
        while ($arElement = $rsElements->Fetch()) {
            $arResult[] = $arElement;
        }
        return $arResult;
    }

    public function getAllGI() {
        return $this->getHlElements(1);;
    }

    public function getAllKI() {
        return $this->getHlElements(2);;
    }

    public function getAllCity(){
        $arResult = array();
        $rsElements = CIBlockElement::GetList(
            array(),
            array(
                'ACTIVE' => 'Y',
                'IBLOCK_ID' => 29
            ),
            false,
            false,
            array(
                'ID',
                'NAME'
            )
        );
        while ($arEl = $rsElements->GetNext()) {
            $arResult[] =$arEl;
        }
        return $arResult;
    }

    public function getAllPrice() {
        return $this->getHlElements(4);
    }

    public function getHlElements ($id) {
        Loader::includeModule("highloadblock");
        $hlbl = $id; // Указываем ID нашего highloadblock блока к которому будет делать запросы.
        $hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch();

        $entity = HL\HighloadBlockTable::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();

        $rsData = $entity_data_class::getList(array(
            "select" => array("*"),
            "order" => array("ID" => "ASC"),
//    "filter" => array("UF_PRODUCT_ID"=>"77","UF_TYPE"=>'33')  // Задаем параметры фильтра выборки
        ));
        $arHlElements = [];
        while($arData = $rsData->Fetch()){
            $arHlElements[] = $arData;
        }
        return $arHlElements;
    }

    public function addService() {
        $arFields = array();
        foreach ($this->arParams["ORGANIZATION"]["PROPERTY"]["SERVICE"]["VALUE"] as $arValue) {
            $arFields[] = array(
                "VALUE" => $arValue,
                "DESCRIPTION" => ''
            );
        }
        $arFields[] = array(
            "VALUE" => $_POST["PROPERTY"],
            "DESCRIPTION" => ''
        );
        CIBlockElement::SetPropertyValuesEx($this->arParams["ORGANIZATION"]["ID"] , $this->arParams["ORGANIZATION"]["IBLOCK_ID"] , array(
            "SERVICE" => $arFields
        ));
    }

    public function getCurrentProp() {
        $keyServiceList = array_search(
            $this->arParams["URL"]["SERVICE_ID"] ,
            $this->arParams["ORGANIZATION"]["PROPERTY"]["SERVICE"]["PROPERTY_VALUE_ID"]
        );
        if ($keyServiceList !== false) {
             return $this->arParams["ORGANIZATION"]["PROPERTY"]["SERVICE"]["VALUE"][$keyServiceList];
        } else {
            return false;
        }
    }

    public function updateProperty(){
        $arFields = array();
        foreach ($this->arParams["ORGANIZATION"]["PROPERTY"]["SERVICE"]["VALUE"] as $arValue) {
            $arFields[] = array(
                "VALUE" => $arValue,
                "DESCRIPTION" => ''
            );
        }
        foreach ($arFields as $intKey => $arValue) {
            if ($arValue["VALUE"]["XML_ID"] == $this->arParams["URL"]["SERVICE_ID"]) {
                $arFields[$intKey]["VALUE"] = $_POST["PROPERTY"];

            }
        }

        foreach ($arFields as $intKey => $arValue) {
            unset($arFields[$intKey]["VALUE"]["XML_ID"]);
        }
//        mpr($arFields , false);
        CIBlockElement::SetPropertyValuesEx($this->arParams["ORGANIZATION"]["ID"] , $this->arParams["ORGANIZATION"]["IBLOCK_ID"] , array(
            "SERVICE" => $arFields
        ));
        LocalRedirect($this->arParams["URL"]["URL_TEMPLATES_SERVICE"]);
    }
    public function deleteProperty(){
        $arFields = array();
        foreach ($this->arParams["ORGANIZATION"]["PROPERTY"]["SERVICE"]["VALUE"] as $arValue) {
            $arFields[] = array(
                "VALUE" => $arValue,
                "DESCRIPTION" => ''
            );
        }
        foreach ($arFields as $intKey => $arValue) {
            if ($arValue["VALUE"]["XML_ID"] == $this->arParams["URL"]["SERVICE_ID"]) {
                unset($arFields[$intKey]["VALUE"][1]);
            }
        }
//        mpr($arFields , false);
        CIBlockElement::SetPropertyValuesEx($this->arParams["ORGANIZATION"]["ID"] , $this->arParams["ORGANIZATION"]["IBLOCK_ID"] , array(
            "SERVICE" => $arFields
        ));
        LocalRedirect($this->arParams["URL"]["URL_TEMPLATES_SERVICE"]);
    }
}