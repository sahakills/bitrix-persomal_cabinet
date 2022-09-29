<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Mail\Event;

CModule::IncludeModule("iblock");

class ProfileAjax extends Controller
{
    public function configureActions() {
        {
            return [
                'getElements' => [
                    'prefilters' => []
                ],
                'getSections' => [
                    'prefilters' => []
                ],
            ];
        }
    }
    //список услуг
    public function getElementsAction($idSection) {
        $arResult = array();
        $rsResult = CIBlockElement::GetList(
            array(),
            array(
                "IBLOCK_ID" => 30,
                "PROPERTY_SERVICE_ITEM" => $idSection
            ),
            false,
            false,
            array(
                "ID",
                "NAME"
            )
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

    //список разделов
    public function getSectionsAction($idSection) {
        $arResult = array();
        $rsResult = CIBlockSection::GetList(
            array(
                "name" => "acs"
            ),
            array(
                "IBLOCK_ID" => 24,
                "ACTIVE" => "Y",
                "SECTION_ID" => $idSection
            ),
            false,
            array(
                "ID",
                "NAME"
            )
        );
        while ($arSection = $rsResult->Fetch()) {
            $arResult[] = $arSection;
        }
        return $arResult;
    }
}