<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="container profile">
    <div class="row">
        <div class="col-12">
            <div class="header-h2">Личный кабинет</div>
        </div>
    </div>
    <div class="row">
        <aside class="col-lg-4 profile-aside">
            <?
            $APPLICATION->IncludeComponent(
                "mendeleev:profile.menu",
                "",
                array(
                    "MENU_LINKS" => $arResult["MENU_LINKS"],
                    "ORGANIZATION" => $arResult["ORGANIZATION"],
                    "IBLOCK_REQUEST" => 32,
                )
            )
            ?>
        </aside>
        <?

            $APPLICATION->IncludeComponent(
                "mendeleev:profile.news",
                "",
                array(
                    "USER" => $arResult["USER"],
                    "ORGANIZATION" => $arResult["ORGANIZATION"],
                    "URL" => $arResult['PATH_TEMPLATE'],
                    "RIGHT_NEWS" => $arParams["RIGHT_NEWS"],
                    "IBLOCK_NEWS" => $arParams["IBLOCK_NEWS"],
                    "SECTION_ID" => 10, //default category
                    "FILTER" => array(
                        "ACTIVE" => "Y"
                    ),
                    "ARCHIVE" => "Y",
                    "URL_MENU_SECTION" => $arResult["PATH_TEMPLATE"]["URL_TEMPLATES_NEWS_SECTION"],
                    "URL_ADD_ITEM" => $arResult["PATH_TEMPLATE"]["URL_TEMPLATES_NEWS_ADD"],
                    "URL_EDIT_ITEM" => $arResult["PATH_TEMPLATE"]["URL_TEMPLATES_NEWS_EDIT"],
                    "URL_ADD_ARCHIVE" => $arResult["PATH_TEMPLATE"]["URL_TEMPLATES_NEWS_ARCHIVE"]
                )
            )
        ?>
    </div>
</div>