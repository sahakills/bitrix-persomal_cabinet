<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use \Bitrix\Main\Mail\Event;
CModule::IncludeModule("iblock");

class ProfileMainOrganization extends CBitrixComponent{

    public function getParentCategory($idChildSection) {
        $arResult = array();

        $rsResult = CIBlockSection::GetNavChain(
            $this->arParams["ORGANIZATION"]["IBLOCK_ID"],
            $idChildSection
        );
        while ($arSection = $rsResult->Fetch()) {
            if ($arSection["DEPTH_LEVEL"] == 1) {
                $arResult = $arSection;
            }
        }
        return $arResult;
    }

    public function getEmptySection() {
        $arResult = array();
        $rsResult = CIBlockSection::GetList(
            array("sort" => "acs"),
            array(
                "IBLOCK_ID" => $this->arParams["ORGANIZATION"]["IBLOCK_ID"],
                "ACTIVE" => "Y",
                "DEPTH_LEVEL" => 1
            ),
            false,
            array(
                "ID",
                "NAME"
            )
        );
        while ($arSection = $rsResult->GetNext()) {
            $arResult[] = $arSection;
        }
//        mpr($arResult , false);
        return $arResult;
    }

    public function getEmployeeOrganizationById($arOrganization) {
        $arResult = array();
        $rsProperty = CIBlockElement::GetProperty(
            $arOrganization['IBLOCK_ID'],
            $arOrganization['ID'],
            "sort",
            "asc",
            array(
                "CODE" => "USER_EMPLOYEE"
            )
        );
        while ($arProp = $rsProperty->Fetch()) {
            if ($arProp) {
                $arUser = CUser::GetByID($arProp['VALUE'])->Fetch();
                $arResult[] = $arUser;
            }
        }
        if (!empty($arResult)) {

            return $arResult;
        } else {
            return false;
        }
    }

    public function getListDirections($arIdSection) {
        $arResult = array();
        $rsResult = CIBlockSection::GetList(
            array(
                "left_margin" => "asc"
            ),
            array(
                "ACTIVE" => "Y",
                "IBLOCK_ID" => $this->arParams["ORGANIZATION"]["IBLOCK_ID"],
                "DEPTH_LEVEL" => 2,
                "SECTION_ID" => $arIdSection
            )
        );
        while ($arSection = $rsResult->Fetch()) {
            $arResult[] = $arSection;
        }
        return $arResult;
    }

    public function getListCategory() {
        $arResult = array();
        $rsResult = CIBlockSection::GetList(
            array(
                "left_margin" => "asc"
            ),
            array(
                "IBLOCK_ID" => $this->arParams["ORGANIZATION"]["IBLOCK_ID"],
                "DEPTH_LEVEL" => 1,
                "ACTIVE" => "Y"
            )
        );
        while ($arSection = $rsResult->Fetch()) {
//            mpr($arSection , false);
            $arResult[] = $arSection;
        }
//        mpr($this->arParams , false);
        return $arResult;
    }

    public function getPropretyUser($strProp) {
        $arResult = array();
        $rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME"=>$strProp));
        while ($arProp = $rsEnum->GetNext()){
            $arResult[] = $arProp;
        }
        return $arResult;

    }

    public function getOrganizationByUser() {
        global $USER;
        $arResult = array();
        $rsResult = CIBlockElement::GetList(
            array(
                "id" => "acs"
            ),
            array(
                "IBLOCK_ID" => $this->arParams["ORGANIZATION"]["IBLOCK_ID"],
//                $arUserPropertySearch
                "PROPERTY_USER_EMPLOYEE" => $USER->GetID()
            )
        );
        while($objElement = $rsResult->GetNextElement()) {
            $arElement = array();
            if ($objElement) {
                $arElement = $objElement->fields;
                $arElement["PROPERTY"] = $objElement->GetProperties();

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

    public function getOrganizationSection() {
        $arResult = array();
        $rsResult = CIBlockElement::GetElementGroups(
            $this->arParams["ORGANIZATION"]["ID"],
            true
        );
        while ($arSection = $rsResult->Fetch()) {
            if ($arSection) {
                $arResult[] = $arSection["ID"];
            }
        }
        if (!empty($arResult)) {
            return $arResult;
        } else {
            return false;
        }
    }

    public function updateOrganization() {
        if ($this->arParams["USER"]["USER_TYPE"] == "organization") {
            $arParamsUtil = array("replace_space"=>"-","replace_other"=>"-");
            $objOrganization = new CIBlockElement;
            $arFieldsOrganization = array(
                "NAME" => $_POST["FIELDS"]["NAME"],
                "CODE" => CUtil::translit($_POST["FIELDS"]["NAME"] , "ru" , $arParamsUtil),
                "IBLOCK_SECTION_ID" => $_POST["FIELDS"]["SECTION"][0],
                "IBLOCK_SECTION" => $_POST["FIELDS"]["SECTION"],
                "ACTIVE" => "N"
            );
            $objOrganization->Update($this->arParams["ORGANIZATION"]["ID"] , $arFieldsOrganization);

            $arProperty = $_POST["PROPERTY"];
//            if ($_POST["PROPERTY"]["INFO_REG_PHOTO"]) {
//                $arProperty["INFO_REG_PHOTO"] = $_FILES[""];
//            }
            if ($_FILES["INFO_REG_PHOTO"]["error"] == 0) {
                $arProperty["INFO_REG_PHOTO"] = $_FILES["INFO_REG_PHOTO"];
            }
            CIBlockElement::SetPropertyValuesEx(
                $this->arParams["ORGANIZATION"]["ID"],
                false,
                $arProperty
            );
            //send message event: ORGANIZATION_MODERATION #EMAIL_TO#
            if ($this->arParams["ORGANIZATION"]["MODERATION"]) {
                $this->sendMailModeration($this->arParams["ORGANIZATION"]["ID"] , $this->arParams["ORGANIZATION"]["NAME"]);
                $this->sendMailOrganization();
            }
        }
    }

    public function sendMailOrganization()
    {
        Event::send(array( //send organization
            "EVENT_NAME" => "PERSONAL_NOTIEC_USER_NEED_MODERATION",
            "LID" => "s1",
            "C_FIELDS" => array(
                "EMAIL_TO" => $this->arParams["USER"]["EMAIL"],
            ),
        ));
    }

    public function sendMailModeration($iOrganizationId, $sOrganizationName)
    {
        Event::send(array( //send moderation
            "EVENT_NAME" => "PERSONAL_NOTIEC_MODER_NEED_MODERATION",
            "LID" => "s1",
            "C_FIELDS" => array(
                "EMAIL_TO", // TODO:: добавить модератора
                "ID_ORGANIZATION" => $iOrganizationId,
                "NAME_ORGANIZATION" => $sOrganizationName
            ),
        ));
    }
}