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
            "mendeleev:profile.request.list",
            "",
            array(
                "USER" => $arResult["USER"],
                "ORGANIZATION" => $arResult["ORGANIZATION"],
                "RIGHT_USER" => $arParams["RIGHT_REQUEST"],
                "IBLOCK_ID" => $arParams["IBLOCK_REQUEST"],
                "MENU_INDEX" => array(
                    array(
                        "URL" => $arResult["PATH_TEMPLATE"]["URL_TEMPLATES_REQUEST"],
                        "NAME" => "Новые заявки"
                    ),
                    array(
                        "URL" => $arResult["PATH_TEMPLATE"]["URL_TEMPLATES_REQUEST_DONE"],
                        "NAME" => "Исполненые заявки"
                    ),
                    array(
                        "URL" => $arResult["PATH_TEMPLATE"]["URL_TEMPLATES_REQUEST_ARCHIVE"],
                        "NAME" => "Архивные заявки"
                    )
                ),
                "FILTER" => array(
                    "IBLOCK_ID" => $arParams["IBLOCK_REQUEST"],
                    "ACTIVE" => "Y",
                    "=PROPERTY_STATUS" => 443,
                    "PROPERTY_ORGANIZATION" => $arResult["ORGANIZATION"]["ID"]
                ),
                "TO_DONE" => false,
                "TO_ARCHIVE" => true
            )
        );
        ?>
    </div>
</div>