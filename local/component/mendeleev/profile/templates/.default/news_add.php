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
        <div class="col-lg-8 profile-view">

            <?

            $APPLICATION->IncludeComponent(
                "mendeleev:profile.news.add",
                "",
                array(
                    "USER" => $arResult["USER"],
                    "ORGANIZATION" => $arResult["ORGANIZATION"],
                    "URL" => $arResult['PATH_TEMPLATE'],
                    "RIGHT_NEWS" => $arParams["RIGHT_NEWS"],
                    "IBLOCK_NEWS" => $arParams["IBLOCK_NEWS"],
                    "IBLOCK_SPEAKER" => $arParams["IBLOCK_SPEAKER"],
                    "FIELDS" => array(
                        "NAME",
                        "ACTIVE_FROM",
                        "DETAIL_TEXT",
                        "DETAIL_PICTURE",
                    ),
                    "AJAX_MODE" => "Y",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "CACHE_TIME" => "3600",
                    "CACHE_TYPE" => "A",
                    "SECTION_ID" => $arResult["PATH_TEMPLATE"]["SECTION_ID"],
                    "URL_MENU_SECTION" => $arResult["PATH_TEMPLATE"]["URL_TEMPLATES_NEWS_SECTION"],
                    "ARCHIVE" => "Y",
                    "PATH_CONFIRM" => $arResult["PATH_TEMPLATE"]["URL_TEMPLATES_NEWS_SECTION"]

                )
            );
            ?>
        </div>
    </div>
</div>