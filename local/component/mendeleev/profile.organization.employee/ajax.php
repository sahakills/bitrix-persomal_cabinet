<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Mail\Event;

CModule::IncludeModule("iblock");

class ProfileOrganizationEmployeeAjax extends Controller
{
    public function configureActions() {
        {
            return [
                'getInfoUser' => [
                    'prefilters' => []
                ],
                'deleteUser' => [
                    'prefilters' => []
                ],
                'addNewUser' => [
                    'prefilters' => []
                ]
            ];
        }
    }

    public function deleteUserAction($idUser) {
        global $USER;
        if ($this->checkUserGet($USER->GetID() , $idUser)) {
            $rsOrganizationUser = CIBlockElement::GetList(
                array(),
                array(
                    "IBLOCK_ID" => 24,
                    "PROPERTY_USER_EMPLOYEE" => $USER->GetID()
                ),
                false,
                false,
                array(
                    "ID"
                )
            )->GetNext();
            if ($rsOrganizationUser) {
                CUser::Delete($idUser);
                $rsElement = CIBlockElement::GetByID($rsOrganizationUser["ID"])->GetNextElement();
                $rsOldProp = $rsElement->GetProperties(
                    array(),
                    array(
                        "CODE" => "USER_EMPLOYEE"
                    )
                );
                unset($rsOldProp["USER_EMPLOYEE"]["VALUE"][array_search($idUser , $rsOldProp["USER_EMPLOYEE"]["VALUE"])]);
                
                CIBlockElement::SetPropertyValuesEx(
                    $rsOrganizationUser["ID"],
                    false,
                    array(
                        "USER_EMPLOYEE" => $rsOldProp["USER_EMPLOYEE"]["VALUE"]
                    )
                );
                return true;
            }
            return false;
            //TODO:: отправка сообщения что пользователей удален
        } else {
            return false;
        }
    }

    public function getInfoUserAction($idGetUser) {
        global $USER;
        $checkUserRight = $this->checkUserGet($USER->GetID() , $idGetUser);
        if ($checkUserRight) {
            $arPropSection = $this->getPropretyUser("UF_EMPLOYEE_SECTION");
            $rsUser = CUser::GetByID($idGetUser)->Fetch();
            if ($rsUser["UF_EMPLOYEE_SECTION"]) {
                foreach ($arPropSection as $arValue) {
                    if (in_array(intval($arValue["ID"]) , $rsUser["UF_EMPLOYEE_SECTION"])) {
                        $arValue["SELECTED"] = true;
                    }
                    $rsUser["UF_EMPLOYEE_SECTION_VALUE"][] = $arValue;
                }
            }
            return $rsUser;
        } else {
            return false;
        }
    }

    public function checkUserGet($idUser , $checkUser) {
        global $USER;
        $rsUser = CUser::GetByID($idUser)->Fetch();
        if ($rsUser["UF_TYPE"] == 1) {
            $rsResult = CIBlockElement::GetList(
                array(),
                array(
                    "IBLOCK_ID" => 24,
                    "PROPERTY_USER_EMPLOYEE" => $idUser
                ),
                false,
                false,
                array(
                    "ID",
                    "NAME",
                    "PROPERTY_USER_EMPLOYEE"
                )
            )->Fetch();

            if (in_array($checkUser , $rsResult["PROPERTY_USER_EMPLOYEE_VALUE"])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getPropretyUser($strProp) {
        $arResult = array();
        $rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME"=>$strProp));
        while ($arProp = $rsEnum->GetNext()){
            $arResult[] = $arProp;
        }
        return $arResult;
    }

}