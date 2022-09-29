<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

CModule::IncludeModule("iblock");

class ProfileNewsList extends CBitrixComponent{


    public function getItems(){
        $arResult = array();
        $arFilter = array(
            "IBLOCK_ID" => $this->arParams["IBLOCK_ID"],

        );
        if ($this->arParams["SECTION_ID"] > 0) {
            $arFilter["SECTION_ID"] = $this->arParams["SECTION_ID"];
        }
        $arProp = $this->arParams["PROPERTIES"];
        foreach ($arProp as &$value) {
            $value = "PROPERTY_".$value;
        }
        $arSelect = array_merge($this->arParams["FIELDS"] , $arProp);
        $arFilter = array_merge($arFilter , $this->arParams["FILTER"]);
        $arFilter["PROPERTY_ORGANIZATION"] = $this->arParams["ORGANIZATION"]["ID"];
        $rsResult = CIBlockElement::GetList(
            array(
                "id" => "desc"
            ),
            $arFilter,
            false,
            false,
            $arSelect
        );
        while ($arElement = $rsResult->Fetch()) {
            $arElement["EDIT_LINK"] = $this->linkEdit($arElement["IBLOCK_SECTION_ID"], $arElement["ID"]);
            $arElement["PREVIEW_PICTURE"] = CFile::GetPath($arElement["PREVIEW_PICTURE"]);
            $arUser = CUser::GetByID($arElement["CREATED_BY"])->Fetch();
            $arElement["USER_NAME"] = $arUser["NAME"];
            $arResult[] = $arElement;
        }
        return $arResult;
    }

    private function linkEdit ($intIdSection , $intIdEl) {
        return \CComponentEngine::MakePathFromTemplate($this->arParams["URL_EDIT_ITEM"], array("SECTION_ID" => $intIdSection , "ELEMENT_ID" => $intIdEl));
    }
}