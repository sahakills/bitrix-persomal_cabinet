<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

CModule::IncludeModule("iblock");

class ProfileNews extends CBitrixComponent{
    public function getSectionList() {
        $arResult = array();
        $arFields = array(
            "IBLOCK_ID" => $this->arParams["IBLOCK_NEWS"],
            "DEPTH_LEVEL" => 1,
        );
//        if ($this->arParams["SECTION_ID"]) {
//            $arFields["ID"] = $this->arParams["SECTION_ID"];
//        }
        $rsResult = CIBlockSection::GetList(
            array(
                "id" => "asc"
            ),
            $arFields,
            false,
            array(
                "ID",
                "NAME",
                "UF_TITLE_LIST"
            )
        );
        while ($arSection = $rsResult->Fetch()) {
            $arSection["LINK_SECTION"] = $this->linkSection($arSection["ID"]);
            $arResult[] = $arSection;
        }
        return $arResult;
    }

    private function linkSection ($intIdSection) {
        return \CComponentEngine::MakePathFromTemplate($this->arParams["URL_MENU_SECTION"], array("SECTION_ID" => $intIdSection));
    }
    public function linkAddItem ($intIdSection) {
        return \CComponentEngine::MakePathFromTemplate($this->arParams["URL_ADD_ITEM"], array("SECTION_ID" => $intIdSection));
    }
}