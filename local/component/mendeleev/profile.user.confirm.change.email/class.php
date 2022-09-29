<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use \Bitrix\Main\Mail\Event;
CModule::IncludeModule("iblock");

class ProfileUserConfirmChangeEmail extends CBitrixComponent{
    public function changeEmail($strCheckWord) {
        $arResult = array();
        $rsUser = CUser::GetList(
            array("sort" => "asc"),
            "sort",
            array(
                "=UF_EMAIL_CHECK_CHECKWORD" => $strCheckWord
            ),
            array(
                "SELECT" => array(
                    "UF_EMAIL_CHECK_CHECKWORD",
                    "UF_TEMP_EMAIL"
                )
            )

        )->Fetch();
//        mpr($rsUser , false);
        if ($rsUser) {
            $objUser = new CUser;
            $arFields = array(
                "EMAIL" => $rsUser["UF_TEMP_EMAIL"],
                "LOGIN" => $rsUser["UF_TEMP_EMAIL"],
                "UF_EMAIL_CHECK_CHECKWORD" => "",
                "UF_TEMP_EMAIL" => ""
            );
            $objUser->Update($rsUser["ID"] , $arFields);
            Event::send(array(
                "EVENT_NAME" => $this->arParams["MSG_EVENT"],
                "LID" => "s1",
                "C_FIELDS" => array(
                    "LOGIN" => $rsUser["UF_TEMP_EMAIL"],
                    "EMAIL_TO" => $rsUser["UF_TEMP_EMAIL"],
                    "NAME" => $rsUser["NAME"],
                )
            ));
            $arResult["UPDATE"] = true;
        } else {
            $arResult["UPDATE"] = false;
            $arResult["ERROR"] = "Неверное секретный ключ";
        }
        return $arResult;
    }
}