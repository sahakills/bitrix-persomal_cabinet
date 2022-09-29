<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Engine\Controller;

CModule::IncludeModule("iblock");

class ProfileAjaxNews extends Controller
{
    public function configureActions() {
        {
            return [
                'addToArchive' => [
                    'prefilters' => []
                ],
                'recoveryArchive' => [
                    'prefilters' => []
                ],
                'deleteFromArchive' => [
                    'prefilters' => []
                ],
            ];
        }
    }

    public function addToArchiveAction($idNews) {
        if ($this->checkRightNews($idNews)) {
            $objElement = new CIBlockElement;
            $arFields = array(
                "ACTIVE" => "N"
            );
            $objElement->Update($idNews, $arFields);
        } else {
            return false;
        }
    }

    public function recoveryArchiveAction($idNews) {
        if ($this->checkRightNews($idNews)) {
            $objElement = new CIBlockElement;
            $arFields = array(
                "ACTIVE" => "Y"
            );
            $objElement->Update($idNews, $arFields);
            return true;
        } else {
            return false;
        }
    }

    public function deleteFromArchiveAction($idNews){
        if ($this->checkRightNews($idNews)) {
            CIBlockElement::Delete($idNews);
            return true;
        } else {
            return false;
        }
    }

    public function checkRightNews($idElement) {
        global $USER;
        $rsUser = CUser::GetByID($USER->GetID())->Fetch();
        $rsResultNews = CIBlockElement::GetByID($idElement)->GetNextElement();
        $arResultPropNews = $rsResultNews->GetProperties(
            array(),
            array(
                "CODE" => "ORGANIZATION"
            )
        );
        $rsResult = CIBlockElement::GetList(
            array(),
            array(
                "IBLOCK_ID" => 24,
                "ID" => intval($arResultPropNews["ORGANIZATION"]["VALUE"]),
                "PROPERTY_USER_EMPLOYEE" => $USER->GetID()
            )
        )->Fetch();
        if ($rsResult && ($rsUser["UF_TYPE"] == 1 || in_array(16 , $rsUser["UF_EMPLOYEE_SECTION"]))) {
            return true;
        } else {
            return false;
        }
    }
}