<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use \Bitrix\Main\Security\Password;
use \Bitrix\Main\Mail\Event;
CModule::IncludeModule("iblock");

class ProfileUserEditType extends CBitrixComponent{

    public function updateUserEmail() {
        global $USER;
        $rsUser = $this->checkMailUser();
        if (!$rsUser) {
            $objUser = new CUser;
            $strHash = $this->createCheckWord();
            $arFieldsUser = array(
                "UF_EMAIL_CHECK_CHECKWORD" => $strHash,
                "UF_TEMP_EMAIL" => $_POST["USER"]["EMAIL"]
            );
            $objUser->Update($USER->GetID() , $arFieldsUser);
            $this->sendConfirmEmail($_POST["USER"]["EMAIL"] , $strHash);
            $arResult = array(
                "UPDATE" => true
            );
        } else {
            $arResult["UPDATE"] = false;
            $arResult["ERROR_UPDATE_EMAIL"] = "Почта уже занята";
        }
        return $arResult;
    }

    public function createCheckWord () {
        global $USER;
        $rsUser = CUser::GetByID($USER->GetID())->Fetch();
        $sUserCheckWord = $rsUser["CHECKWORD"];
        $sUserLastLogin = $rsUser["LAST_LOGIN"];
        $sHash = Password::hash($sUserCheckWord.$sUserLastLogin);
        return $sHash;
    }
    public function checkMailUser() {
        $rsResult = CUser::GetList(
            ($by="id"),
            ($order="desc"),
            array(
                "EMAIL" => $_POST["USER"]["EMAIL"]
            )
        )->Fetch();
        if ($rsResult) {
            return true;
        } else {
            return false;
        }
    }

    public function sendConfirmEmail($strNewEmail , $sHash) {
        global $USER;
        Event::send(array(
            "EVENT_NAME" => $this->arParams["MSG_EVENT"],
            "LID" => "s1",
            "C_FIELDS" => array(
                "LOGIN" => $USER->GetLogin(),
                "EMAIL_TO" => $strNewEmail,
                "NAME" => $USER->GetFullName(),
                "CHECKWORD" => $sHash,
                "PATH_CONFIRM" => $this->arParams["PATH_CONFIRM_EMAIL"]
            )
        ));
    }


    public function updateUserPassword() {
        global $USER;
        $arResult = array();
        if ($_POST["USER"]["PASSWORD"] == $_POST["USER"]["CONFIRM_PASSWORD"]) {
            if ($this->checkOldPassword($_POST["USER"]["OLD_PASSWORD"])) {
                $objUser = new CUser;
                $arFieldsUser = array(
                    "PASSWORD" => $_POST["USER"]["PASSWORD"],
                    "CONFIRM_PASSWORD" => $_POST["USER"]["CONFIRM_PASSWORD"]
                );
                $objUser->Update($USER->GetID() , $arFieldsUser);

                //TODO:: send message
                Event::send(array(
                    "EVENT_NAME" => "PERSONAL_NOTIEC_CHANGE_PASSWORD",
                    "LID" => "s1",
                    "C_FIELDS" => array(
                        "EMAIL_TO" => $USER->GetEmail(), // TODO:: добавить модератора
                    ),
                ));
                $arResult["UPDATE"] =  true;

            } else {
                $arResult["UPDATE"] =  false;
                $arResult["ERROR_UPDATE_PASSWORD"] = "Старый пароль не верный";
            }
        } else {
            $arResult["UPDATE"] = false;
            $arResult["ERROR_UPDATE_PASSWORD"] = "Пароли не совпадают";
        }
        return $arResult;
    }

    public function checkOldPassword($password){
        global $USER;
        $userData = CUser::GetByID($USER->GetID())->Fetch();
        return Password::equals($userData['PASSWORD'], $password);
    }
}