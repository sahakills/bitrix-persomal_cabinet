<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use \Bitrix\Main\Type\DateTime;
CModule::IncludeModule("iblock");
class ProfileNewsAdd extends CBitrixComponent{

    public function getPropListTag() {
        $arResult = array();
        $rsResult = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$this->arParams["IBLOCK_NEWS"], "CODE"=>"TAG_LIST"));
        while($enumFields = $rsResult->Fetch()) {
            $arResult[] = $enumFields;
        }
        return $arResult;
    }

    public function getSectionInfo($idSection){

        $arResult = CIBlockSection::GetList(
            array(),
            array(
                "IBLOCK_ID" => $this->arParams["IBLOCK_NEWS"],
                "ID" => $idSection
            ),
            false,
            array(
                "ID",
                "IBLOCK_ID",
                "NAME",
                "UF_TEMPLATE_SECTION",
                "UF_TEMPLATE_NAME_HEADER"
            )
        )->Fetch();
        if ($arResult["UF_TEMPLATE_SECTION"]) {
            $arResult["TEMPLATE"] = CUserFieldEnum::GetList(
                array(),
                array(
                    "ID" => $arResult["UF_TEMPLATE_SECTION"]
                )
            )->Fetch()["VALUE"];
        } else {
            $arResult["TEMPLATE"] = false;
        }
        $arResult["LINK_BACK"] = $this->linkSection($arResult["ID"]);

        return $arResult;
    }
    public function addItems($IBLOCK_ID , $IBLOCK_SECTION_ID) {

        $objElement = new CIBlockElement;
        global $USER;
        //параметры для обычной и категории из списка доп параметров
        $arFields["ELEMENTS"] = array();

        $arFieldsElements = array();

        //detail-picture
        $arParamsCODETranslit = array("replace_space"=>"-","replace_other"=>"-");
        if ($_POST["element"]) {
            foreach ($_POST["element"]["TITLE"] as $key => $value) {
                $arFieldsElements[$key]["NAME"] = $value;
                $arFieldsElements[$key]["ACTIVE"] = "Y";
                $arFieldsElements[$key]["CREATED_BY"] = $USER->GetID();
                $arFieldsElements[$key]["IBLOCK_ID"] = $IBLOCK_ID;
                $arFieldsElements[$key]["IBLOCK_SECTION_ID"] = $IBLOCK_SECTION_ID;
                $arFieldsElements[$key]["PROPERTY_VALUES"]["ORGANIZATION"] = $this->arParams["ORGANIZATION"]["ID"];
                $arFieldsElements[$key]["CODE"] = CUtil::translit($value, "ru" , $arParamsCODETranslit);
            }
            if ($_POST["element"]["date-active"]) {
                foreach ($_POST["element"]["date-active"] as $key => $value) {
                    if ($value) {
                        $arFieldsElements[$key]["ACTIVE_FROM"] = new DateTime($value , "Y-m-d");
                    } else {
                        $arFieldsElements[$key]["ACTIVE_FROM"] = new DateTime(time() , "Y-m-d");
                    }
                }
            }
            foreach ($_POST["element"]["text-detail"] as $key => $value) {
                $arFieldsElements[$key]["DETAIL_TEXT"] = $value;
                $arFieldsElements[$key]["DETAIL_TEXT_TYPE"] = "html";

            }
            if ($_POST["element"]["text-preview"]) {
                foreach ($_POST["element"]["text-preview"] as $key => $value) {
                    $arFieldsElements[$key]["PREVIEW_TEXT"] = $value;
                    $arFieldsElements[$key]["PREVIEW_TEXT"] = "html";
                }
            }
            if ($_POST["element"]["sourse"]) {
                foreach ($_POST["element"]["sourse"] as $key => $value) {
                    $arFieldsElements[$key]["PROPERTY_VALUES"]["SOURSE"] = $value;
                }
            }
            if ($_POST["element"]["event-date"]) {
                foreach ($_POST["element"]["event-date"] as $key => $value) {
                    $arFieldsElements[$key]["PROPERTY_VALUES"]["EVENTS_TIME"] = $value;
                }
            }
            if ($_POST["element"]["event-time"]) {
                foreach ($_POST["element"]["event-time"] as $key => $value) {
                    $arFieldsElements[$key]["PROPERTY_VALUES"]["EVENTS_TIME"] .= " ". $value;
                }
            }
            if ($_POST["element"]["event-place"]) {
                foreach ($_POST["element"]["event-place"] as $key => $value) {
                    $arFieldsElements[$key]["PROPERTY_VALUES"]["EVENTS_PLACE"] = $value;
                }
            }
            if ($_POST["element"]["SPEAKER"]["NAME"]) {
                foreach ($_POST["element"]["SPEAKER"]["NAME"] as $key => $value) {
                    if ($value != "") {
                        $intSpeaker = $this->addSpeaker(
                            $_POST["element"]["SPEAKER"]["NAME"][$key],
                            $_POST["element"]["SPEAKER"]["POSITION"][$key]
                        );
                        $arFieldsElements[$key]["PROPERTY_VALUES"]["SPEAKER_ITEM"] = $intSpeaker;
                    }
                }
            }
        }

        if (!empty($_POST["TAG_LIST"])) {
            foreach ($_POST["TAG_LIST"] as $key => $sValue) {
                $arFieldsElements[$key]["PROPERTY_VALUES"]["TAG_LIST"] = $sValue;
            }
        }
        if (!empty($_POST["element"]["link_video"])) {
            foreach ($_POST["element"]["link_video"] as $key => $sValue) {
                $arFieldsElements[$key]["PROPERTY_VALUES"]["VIDEO"] = $sValue;
            }
        }
        foreach ($_FILES["detail-picture"]["name"] as $key => $sValue) {
            $arFieldsElements[$key]["PROPERTY_VALUES"]["WIDE_IMG"]['name'] = $sValue;
            $arFieldsElements[$key]["PREVIEW_PICTURE"]['name'] = $sValue;
        }
        foreach ($_FILES["detail-picture"]["type"] as $key => $sValue) {
            $arFieldsElements[$key]["PROPERTY_VALUES"]["WIDE_IMG"]['type'] = $sValue;
            $arFieldsElements[$key]["PREVIEW_PICTURE"]['type'] = $sValue;
        }
        foreach ($_FILES["detail-picture"]["tmp_name"] as $key => $sValue) {
            $arFieldsElements[$key]["PROPERTY_VALUES"]["WIDE_IMG"]['tmp_name'] = $sValue;
            $arFieldsElements[$key]["PREVIEW_PICTURE"]['tmp_name'] = $sValue;
        }
        foreach ($_FILES["detail-picture"]["size"] as $key => $sValue) {
            $arFieldsElements[$key]["PROPERTY_VALUES"]["WIDE_IMG"]['size'] = $sValue;
            $arFieldsElements[$key]["PREVIEW_PICTURE"]['size'] = $sValue;
        }

        foreach ($arFieldsElements as $arValue) {
           if ($objElement->Add($arValue)) {
               LocalRedirect($this->linkSection($IBLOCK_SECTION_ID));
           } else {
               return false;
           }

        }

    }

    public function addSpeaker($strName , $strPosition = false) {
        $arResult = array();

        $rsResult = CIBlockElement::GetList(
            array(),
            array(
                "IBLOCK_ID" => $this->arParams["IBLOCK_SPEAKER"],
                "NAME" => trim($strName),
            )
        )->Fetch();
        if ($rsResult) {
            return $rsResult["ID"];
        } else {
            $objElement = new CIBlockElement;
            $arFields = array(
                "IBLOCK_ID" => $this->arParams["IBLOCK_SPEAKER"],
                "NAME" => trim($strName),
                "PROPERTY" => array(
                    "POSITION" => $strPosition
                )
            );
            return $arResult = $objElement->Add($arFields);
        }
    }
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
            $arFields
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
}
