<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Mail\Event;

CModule::IncludeModule("forum");
CModule::IncludeModule("iblock");

class ProfileRequestAjax extends Controller
{
    public function configureActions()
    {
        {
            return [
                'addToDone' => [
                    'prefilters' => []
                ],
                'addToArchive' => [
                    'prefilters' => []
                ],
            ];
        }
    }

    public function addToDoneAction($id) {
        if ($this->checkRight()) {
            $objUser = new CIBlockElement;
            $objUser->Update($id , array(
                "ACTIVE" => "Y"
            ));
            CIBlockElement::SetPropertyValuesEx($id, false , array(
                "STATUS" => 443
            ));
            return $id;
        }
    }

    public function addToArchiveAction($id , $strText) {
        if ($this->checkRight()) {
            $objEl = new CIBlockElement;
            $objEl->Update($id , array(
                "ACTIVE" => "N"
            ));
            CIBlockElement::SetPropertyValuesEx($id, false , array(
                "STATUS" => 444,
                "COMMENTS" => $strText
            ));
            return array($id , $strText);
        }

    }

    public function checkRight() {
        return true;
    }
}