<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

CModule::IncludeModule("iblock");

class ProfileService extends CBitrixComponent{

    public function getServiceList() {
        $arResult = array();
        $arServiceID = array();
        $arServices = array();
        foreach ($this->arParams["ORGANIZATION"]["PROPERTY"]["SERVICE"]["VALUE"] as $intKey => $value) {
                $arServiceID[] = $value[1]; // 1 id услуги
            $this->arParams["ORGANIZATION"]["PROPERTY"]["SERVICE"]["VALUE"][$intKey]["XML_ID"] = $this->arParams["ORGANIZATION"]["PROPERTY"]["SERVICE"]["PROPERTY_VALUE_ID"][$intKey];
        }

        if (!empty($arServiceID)) {

            $rsResultService = CIBlockElement::GetList(
                array(
                    "sort" => "acs"
                ),
                array(
                    "ACTIVE" => "Y",
                    "IBLOCK_ID" => 30,
                    "ID" => $arServiceID
                ),
                false,
                false,
                array(
                    "ID",
                    "NAME",
                    "IBLOCK_SECTION_ID",
                    "PROPERTY_SERVICE_ITEM"
                )
            );

            while($arServiceItem = $rsResultService->Fetch()) {
                $arServices[] = $arServiceItem;
//                $intKeyValue = array_search($arServiceItem["ID"] , array_column($this->arParams["ORGANIZATION"]["PROPERTY"]["SERVICE"]["VALUE"] , 1) );
//                $idValueProp = $this->arParams["ORGANIZATION"]["PROPERTY"]["SERVICE"]["PROPERTY_VALUE_ID"][$intKeyValue];
//                $arServiceItem['LINK_EDIT'] = $this->linkEdit($arServiceItem["PROPERTY_SERVICE_ITEM_VALUE"][0],$idValueProp);
//
//                if ($arServiceItem["PROPERTY_SERVICE_ITEM_VALUE"]) {
//                    foreach ($arServiceItem["PROPERTY_SERVICE_ITEM_VALUE"] as $intKey => $intValue) {
//                        $arResult[$intValue][] = $arServiceItem;
//                    }
//                }
            }
            foreach ($this->arParams["ORGANIZATION"]["PROPERTY"]["SERVICE"]["VALUE"] as $intKey => $arValue) {
                foreach ($arServices as $intKeyService => $arValueService) {
                    if ($arValueService["ID"] == $arValue[1]) {
                        foreach ($arValueService["PROPERTY_SERVICE_ITEM_VALUE"] as $intSection) {
                            $arValueService["LINK_EDIT"] = $this->linkEdit($intSection , $arValue["XML_ID"]);
                            $arResult[$intSection][] = array_merge($arValueService , $arValue);
                        }
                    }
                }
            }
            foreach ($arResult as $intKey => $arValue) {
                $rsResultSection = CIBlockSection::GetByID($intKey)->Fetch();
                $arResult[$rsResultSection["NAME"]] = $arValue;
                unset($arResult[$intKey]);
            }

            return $arResult;
        } else {
            return false;
        }

    }
    private function linkEdit ($idSection , $intService) {
        return \CComponentEngine::MakePathFromTemplate($this->arParams["URL"]["URL_TEMPLATES_SERVICE_EDIT"], array("SECTION_ID" => $idSection, "SERVICE_ID" => $intService));
    }
}