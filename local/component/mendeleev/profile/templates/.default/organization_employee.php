<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>
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
                "mendeleev:profile.organization.employee",
                "",
                array(
                    "USER" => $arResult["USER"],
                    "ORGANIZATION" => $arResult["ORGANIZATION"],
                    "URL" => $arResult['PATH_TEMPLATE'],
                    "USER_TYPE_ORGANIZATION" => $arParams["USER_TYPE_ORGANIZATION"],
                    "AJAX_MODE" => "Y",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "Y",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "CACHE_TYPE" => "N",
                    "CACHE_TIME" => "0",
                    "URL_MENU" => array(
                        array(
                            "URL" => $arResult["PATH_TEMPLATE"]["URL_TEMPLATES_INDEX"],
                            "NAME" => "Данные организации"
                        ),
                        array(
                            "URL" => $arResult["PATH_TEMPLATE"]["URL_TEMPLATES_ORGANIZATION_EMPLOYEE"],
                            "NAME" => "Сотрудники"
                        ),

                    )
                ),
                $component
            );
            ?>
        </div>
    </div>
</div>