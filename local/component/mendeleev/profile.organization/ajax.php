<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Mail\Event;

CModule::IncludeModule("forum");
CModule::IncludeModule("iblock");

class ProfileOrganizationAjax extends Controller
{
    public function configureActions() {
        {
            return [
                'getSections' => [
                    'prefilters' => []
                ],
            ];
        }
    }

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