<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

CModule::IncludeModule("iblock");

class ProfileEmployee extends CBitrixComponent
{
    public function updateUserInfo() {
        global $USER;
        $objUser = new CUser;
        $objUser->Update($USER->GetID(), $_POST["USER"]);
        return true;
    }
}