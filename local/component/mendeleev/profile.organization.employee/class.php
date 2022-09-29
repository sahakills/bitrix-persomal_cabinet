<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Mail\Event;

CModule::IncludeModule("iblock");

class ProfileMainOrganizationEmployee extends CBitrixComponent
{

    public function getPropretyUser($strProp) {
        $arResult = array();
        $rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME"=>$strProp));
        while ($arProp = $rsEnum->GetNext()){
            $arResult[$arProp["ID"]] = $arProp;
        }
        return $arResult;
    }

    public function checkRightUser() {

        if ($this->arParams["USER"]["UF_TYPE"] == 1) {
            if (in_array($this->arParams["USER"]["ID"] , $this->arParams["ORGANIZATION"]["PROPERTY"]["USER_EMPLOYEE"]["VALUE"])) {
                return true;
            }
            else {
                return false;
            }
        }
    }

    public function getEmployeeOrganization()
    {
        $arResult = array();
        $rsProperty = CIBlockElement::GetProperty(
            $this->arParams["ORGANIZATION"]['IBLOCK_ID'],
            $this->arParams["ORGANIZATION"]['ID'],
            "sort",
            "asc",
            array(
                "CODE" => "USER_EMPLOYEE"
            )
        );
        $arPropertySection = $this->getPropretyUser("UF_EMPLOYEE_SECTION");
        while ($arProp = $rsProperty->Fetch()) {
            if ($arProp) {
                $arUser = CUser::GetByID($arProp['VALUE'])->Fetch();
                if ($arUser["UF_TYPE"] != $this->arParams["USER_TYPE_ORGANIZATION"]) {
                    if ($arUser["UF_EMPLOYEE_SECTION"]) {
                        foreach ($arUser["UF_EMPLOYEE_SECTION"] as $intID) {
                            $arUser["SECTION_VALUE"][] = $arPropertySection[$intID]["VALUE"];
                        }
                    }
                    $arResult[] = $arUser;
                }
            }
        }
        if (!empty($arResult)) {

            return $arResult;
        } else {
            return false;
        }
    }

    public function upDateUser() {
        if ($this->checkRightUser()) {
            $arFieldsUser = array();
            if(!empty($_POST["USER"]["FIELD"])){
                $arFieldsUser += $_POST["USER"]["FIELD"];
            }
            if (!empty($_POST["USER"]["PROPERTY"])) {
                $arFieldsUser += $_POST["USER"]["PROPERTY"];
            }
            if(!empty($arFieldsUser)){
                $rsUser = new CUser;
                $rsUser->Update($_POST["USER"]["ID"] , $arFieldsUser);
                //TODO:: отправка почты новому пользоателю
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function addEmployee(){
        if ($this->checkRightUser()) {
            global $USER;
            $arFieldsUser = array_merge($_POST["USER"]["FIELD"] , $_POST["USER"]["PROPERTY"]);
            $arFieldsUser["LOGIN"] = $_POST["USER"]["FIELD"]["EMAIL"];
            $arFieldsUser["UF_TYPE"] = 2;
            $tempPassword = randString(7);
            $arFieldsUser["PASSWORD"] = $tempPassword;
            $arFieldsUser["CONFIRM_PASSWORD"] = $tempPassword;
            $objUser = new CUser;
            if ($idNewUser = $objUser->Add($arFieldsUser)) {
                $arPropertySection = $this->getPropretyUser("UF_EMPLOYEE_SECTION");
                $arUserSectionName = array();
                foreach ($arFieldsUser["UF_EMPLOYEE_SECTION"] as $intValue) {
                    $arUserSectionName[] = $arPropertySection[$intValue]["VALUE"];
                }
                $rsElement = CIBlockElement::GetByID($this->arParams["ORGANIZATION"]["ID"])->GetNextElement();
                $rsOldProp = $rsElement->GetProperties(
                    array(),
                    array(
                        "CODE" => "USER_EMPLOYEE"
                    )
                );
                $rsOldProp["USER_EMPLOYEE"]["VALUE"][] = $idNewUser;
                CIBlockElement::SetPropertyValuesEx(
                    $this->arParams["ORGANIZATION"]["ID"],
                    false,
                    array(
                        "USER_EMPLOYEE" => $rsOldProp["USER_EMPLOYEE"]["VALUE"]
                    )
                );
                $this->sendMailEmployee($idNewUser , $arUserSectionName);
                return true;
            } else {
                return $objUser->LAST_ERROR;
            }

        } else {
            return false;
        }
    }

    public function sendMailEmployee($idNewUser , $userSection) {
        $rsUser = CUser::GetByID($idNewUser)->Fetch();

        Event::send(array( //send moderation
            "EVENT_NAME" => "PERSONAL_NOTIEC_MODER_ADD_NEW_EMPLOYEE",
            "LID" => "s1",
            "C_FIELDS" => array(
                "EMAIL_TO" => $this->arParams["USER"]["EMAIL"],
                "NAME_ORGANIZATION" => $this->arParams["ORGANIZATION"]["NAME"],
                "USER" => $rsUser["LAST_NAME"] . " " . $rsUser["NAME"]. " " . $rsUser["SECOND_NAME"],
                "LOGIN" => $rsUser["LOGIN"],
                "USER_SECTION" => implode(', ', $userSection)
            ),
        ));

        Event::send(array( //send employee
            "EVENT_NAME" => "PERSONAL_NOTIEC_USER_ADD_EMPLOYEE",
            "LID" => "s1",
            "C_FIELDS" => array(
                "EMAIL_TO" => $rsUser["EMAIL"],
                "NAME_ORGANIZATION" => $this->arParams["ORGANIZATION"]["NAME"],
                "LOGIN" => $rsUser["LOGIN"]
            ),
        ));
    }
}