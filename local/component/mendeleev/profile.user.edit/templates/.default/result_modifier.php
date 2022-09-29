<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;
CModule::IncludeModule('iblock');
CModule::IncludeModule('highloadblock');


if (!empty($arResult['arUser']['UF_PROPACCESS'])) {
    $hlblock = HL\HighloadBlockTable::getById(2)->fetch(); // id highload блока
    $entity = HL\HighloadBlockTable::compileEntity($hlblock);
    $entityClass = $entity->getDataClass();
    $res = $entityClass::getList(array(
        'select' => array('*'),
        //'order' => array('ID' => 'ASC'),
        'filter' => array('ID' => $arResult['arUser']['UF_PROPACCESS'])
    ))->fetch();
    $arResult['arUser']['UF_PROPACCESS'] = $res['UF_HL_PROPACCESS'];
}
if (!empty($arResult['arUser']['UF_GROUP_DISABILITY'])) {
    $hlblock = HL\HighloadBlockTable::getById(3)->fetch(); // id highload блока
    $entity = HL\HighloadBlockTable::compileEntity($hlblock);
    $entityClass = $entity->getDataClass();
    $res = $entityClass::getList(array(
        'select' => array('*'),
        //'order' => array('ID' => 'ASC'),
        'filter' => array('ID' => $arResult['arUser']['UF_GROUP_DISABILITY'])
    ))->fetch();
//    mpr($res , false);
    $arResult['arUser']['UF_GROUP_DISABILITY'] = $res['UF_PROPDISABILLITY'];
}
mpr($arResult, true);