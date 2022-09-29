<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

CModule::IncludeModule("iblock");

class ProfileMenu extends CBitrixComponent {
    public function countElemetsRequst() {
        $countItem = 0;
        $rsResult = CIBlockElement::GetList(
            array(),
            array(
                "IBLOCK_ID" => $this->arParams["IBLOCK_REQUEST"],
                "ACTIVE" => "Y",
                "!PROPERTY_STATUS" => 443,
                "PROPERTY_ORGANIZATION" => $this->arParams["ORGANIZATION"]["ID"]
            )
        );
        while ($arElement = $rsResult->Fetch()) {
            if ($arElement) {
                $countItem++;
            }
        }
        return $countItem;
    }
}