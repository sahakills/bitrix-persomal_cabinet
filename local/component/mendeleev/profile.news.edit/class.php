<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Type\DateTime;

CModule::IncludeModule("iblock");

class ProfileNewsEdit extends CBitrixComponent
{
    public function getPropListTag() {
        $arResult = array();
        $rsResult = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$this->arParams["IBLOCK_NEWS"], "CODE"=>"TAG_LIST"));
        while($enumFields = $rsResult->Fetch()) {
            $arResult[] = $enumFields;
        }
        return $arResult;
    }
    public function getSectionInfo($idSection){
//        $rsResult = CIBlockSection::GetByID($idSection)->Fetch();

        $rsResult = CIBlockSection::GetList(
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
                "UF_TEMPLATE_SECTION"
            )
        )->Fetch();
        if ($rsResult["UF_TEMPLATE_SECTION"]) {

            $rsResult["TEMPLATE"] = CUserFieldEnum::GetList(
                array(),
                array(
                    "ID" => $rsResult["UF_TEMPLATE_SECTION"]
                )
            )->Fetch()["VALUE"];
        } else {
            $rsResult["TEMPLATE"] = false;
        }
        $rsResult["LINK_BACK"] = $this->linkSection($rsResult["ID"]);
        return $rsResult;
    }
    public function getElement() {
        $arResult = array();
//        $rsResult = CIBlockElement::GetByID($this->arParams["URL"]["ELEMENT_ID"])->GetNextElement();
        $rsResult = CIBlockElement::GetList(
            array(),
            array(
                "IBLOCK_ID" => $this->arParams["IBLOCK_NEWS"],
                "ID" => $this->arParams["URL"]["ELEMENT_ID"],
                "SECTION_ID" => $this->arParams["URL"]["SECTION_ID"]
            )
        )->GetNextElement();
        if ($rsResult) {
            $arResult["FIELDS"] = $rsResult->GetFields();
            if ($arResult["FIELDS"]["PREVIEW_PICTURE"]) {
                $arResult["FIELDS"]["PREVIEW_PICTURE"] = CFile::GetFileArray($arResult["FIELDS"]["PREVIEW_PICTURE"]);
            }
            $arResult["PROPERTY"] = $rsResult->GetProperties();
            if ($arResult["PROPERTY"]["SPEAKER_ITEM"]["VALUE"]) {
                $rsResult = CIBlockElement::GetByID($arResult["PROPERTY"]["SPEAKER_ITEM"]["VALUE"])->GetNextElement();
                if ($rsResult) {
                    $arSpeaker["FIELDS"] = $rsResult->GetFields();
                    $arSpeaker["PROPERTY"] = $rsResult->GetProperties();
                    $arResult["PROPERTY"]["SPEAKER_ITEM"] = $arSpeaker;
                }
            }

            return $arResult;
        } else {
            return false;
        }
    }
    public function editItems($IBLOCK_ID , $IBLOCK_SECTION_ID) {
        $objElement = new CIBlockElement;
        global $USER;
        //параметры для обычной и категории из списка доп параметров
        $arFields["ELEMENTS"] = array();
        $arFieldsElements = array();
        //detail-picture
        $arParamsCODETranslit = array("replace_space"=>"-","replace_other"=>"-");
        $arFieldsElements["ACTIVE"] = "Y";
        $arFieldsElements["NAME"] = $_POST["TITLE"];
        $arFieldsElements["CODE"] = CUtil::translit($_POST["TITLE"] , "ru" , $arParamsCODETranslit);
        $arFieldsElements["CREATED_BY"] = $USER->GetID();
        $arFieldsElements["DETAIL_TEXT"] = $_POST["text-detail"];
        $arFieldsElements["DETAIL_TEXT_TYPE"] = 'html';
        $arFieldsElements["IBLOCK_ID"] = $IBLOCK_ID;
        $arFieldsElements["IBLOCK_SECTION_ID"] = $IBLOCK_SECTION_ID;
        $arFieldsElements["PROPERTY_VALUES"]["ORGANIZATION"] = $this->arParams["ORGANIZATION"]["ID"];
        $arFieldsElements["PROPERTY_VALUES"]["SOURSE"] = $_POST["sourse"];
        if ($_POST["date-active"]) {
            $arFieldsElements["ACTIVE_FROM"] = new DateTime($_POST["date-active"] , "Y-m-d");
        }
        if ($_POST["event-time"]) {
            $arFieldsElements["PROPERTY_VALUES"]["EVENTS_TIME"] = $_POST["event-time"];
        }
        if ($_POST["event-place"]) {
            $arFieldsElements["PROPERTY_VALUES"]["EVENTS_PLACE"] = $_POST["event-place"];
        }

        if ($_POST["TAG_LIST"]) {
            $arFieldsElements["PROPERTY_VALUES"]["TAG_LIST"] = $_POST["TAG_LIST"];
        }
        if ($_POST["SPEAKER"]) {
            $this->updateSpeaker($_POST["SPEAKER"]["ID"] , $_POST["SPEAKER"]["NAME"] , $_POST["SPEAKER"]["POSITION"]);
            $arFieldsElements["PROPERTY_VALUES"]["SPEAKER_ITEM"] = $_POST["SPEAKER"]["ID"];
        }
        if ($_POST["link_video"]) {
            $arFieldsElements["PROPERTY_VALUES"]["VIDEO"] = $_POST["link_video"];
        }
        if (intval($_FILES["detail-picture"]["error"]) !== 4) {
            $arFieldsElements["PROPERTY_VALUES"]["WIDE_IMG"] = $_FILES["detail-picture"];
            $arFieldsElements["PREVIEW_PICTURE"] = $_FILES["detail-picture"];
            $arFieldsElements["DETAIL_PICTURE"] = $_FILES["detail-picture"];
        } elseif (empty($_POST["old_preview"])) {
            $arFieldsElements["PROPERTY_VALUES"]["WIDE_IMG"] = ['del' => 'Y'];
            $arFieldsElements["PREVIEW_PICTURE"] = ['del' => 'Y'];
            $arFieldsElements["DETAIL_PICTURE"] = ['del' => 'Y'];
        }
        return $rsResult = $objElement->Update($this->arParams["URL"]["ELEMENT_ID"] , $arFieldsElements);

    }

    public function updateSpeaker($id , $name , $position) {
        $objElement = new CIBlockElement;
        $arFields = array(
            "NAME" => $name,
        );
        $objElement->Update($id , $arFields);
        CIBlockElement::SetPropertyValuesEx($id , false , array(
            "POSITION" => $position
        ));
    }
    private function linkSection ($intIdSection) {
        return \CComponentEngine::MakePathFromTemplate($this->arParams["URL_MENU_SECTION"], array("SECTION_ID" => $intIdSection));
    }
}