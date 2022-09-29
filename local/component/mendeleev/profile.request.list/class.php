<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

CModule::IncludeModule("iblock");

class ProfileRequestList extends CBitrixComponent
{
    public function getItems()
    {
        $arResult = array();
        $rsResult = CIBlockElement::GetList(
            array(),
            $this->arParams["FILTER"]
        );
        while ($arElement = $rsResult->GetNextElement()) {
            $ar = array();
            $ar["FIELDS"] = $arElement->GetFields();
            $ar["PROPERTY"] = $arElement->GetProperties();
            $arResult[] = $ar;
        }
        if ($arResult) {
            return $arResult;
        } else {
           return false;
        }
    }
}