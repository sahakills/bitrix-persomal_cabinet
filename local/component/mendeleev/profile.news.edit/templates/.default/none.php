<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
$APPLICATION->IncludeComponent(
    "mendeleev:profile.menu.inner.section",
    "",
    array(
        "IBLOCK_ID" => $arParams["IBLOCK_NEWS"],
        "CURRENT_SECTION" => $arParams["SECTION_ID"],
        "ARCHIVE" => $arParams["ARCHIVE"],
        "URL_MENU_ARCHIVE" => $arParams["URL"]["URL_TEMPLATES_NEWS_ARCHIVE"],
        "URL_MENU_SECTION" => $arParams["URL_MENU_SECTION"],
    )
);
?>
<div class="row profile-view-wrap services news-add-element">
    <div class="services-box">
        <div class="header-h3">Элемент не найден</div>
    </div>
</div>
