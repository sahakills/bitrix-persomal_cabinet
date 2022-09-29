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
                    "RIGHT_NEWS" => $arParams["RIGHT_HOBBY"],
                    "IBLOCK_NEWS" => $arParams["IBLOCK_HOBBY"],
                    "SECTION_ID" => 13, //default category
                    "FILTER" => array(
                        "ACTIVE" => "Y"
                    ),
                    "ARCHIVE" => "N",
                    "URL_MENU_SECTION" => $arResult["PATH_TEMPLATE"]["URL_TEMPLATES_HOBBY_SECTION"],
                    "URL_ADD_ITEM" => $arResult["PATH_TEMPLATE"]["URL_TEMPLATES_HOBBY_ADD"],
                    "URL_EDIT_ITEM" => $arResult["PATH_TEMPLATE"]["URL_TEMPLATES_HOBBY_EDIT"],
                    "TEMPLATE_ITEM_LIST" => "hobby"
                 )
            )
        ?>

    </div>
</div>