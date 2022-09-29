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
        <?
        switch ($arResult['USER']['USER_TYPE']) {
            case "default":
                $APPLICATION->IncludeComponent(
                    "mendeleev:profile.user",
                    "",
                    array(
                        "CHECK_RIGHTS" => "N",
                        "SEND_INFO" => "N",
                        "SET_TITLE" => "Y",
                        "USER_PROPERTY" => array("UF_PROPACCESS", "UF_GROUP_DISABILITY"),
                        "USER_PROPERTY_NAME" => ""
                    )
                );
                break;
            case "organization":
                ?>
                <div class="col-lg-8 profile-view">
                <?
                    $APPLICATION->IncludeComponent(
                        "mendeleev:profile.organization",
                        "",
                        array(
                            "USER" => $arResult["USER"],
                            "ORGANIZATION" => $arResult["ORGANIZATION"],
                            "URL" => $arResult['PATH_TEMPLATE'],
                            "AJAX_MODE" => "Y",
                            "AJAX_OPTION_ADDITIONAL" => "",
                            "AJAX_OPTION_HISTORY" => "N",
                            "AJAX_OPTION_JUMP" => "N",
                            "AJAX_OPTION_STYLE" => "Y",
                            "URL_MENU" => array(
                                array(
                                    "URL" => $arResult["PATH_TEMPLATE"]["URL_TEMPLATES_INDEX"],
                                    "NAME" => "Данные организации"
                                ),
                                array(
                                    "URL" => $arResult["PATH_TEMPLATE"]["URL_TEMPLATES_ORGANIZATION_EMPLOYEE"],
                                    "NAME" => "Сотрудники",
                                    "ACTIVE" => ($arResult["ORGANIZATION"]["MODERATION"]) ? "Y" : "N"
                                ),

                            )
                        )
                    );
                ?>
                </div>
                <?
                break;

            case "employee":
                ?><div class="col-lg-8 profile-view"><?
                $APPLICATION->IncludeComponent(
                    "mendeleev:profile.employee",
                    "",
                    array(
                        "USER" => $arResult["USER"],
                        "ORGANIZATION" => $arResult["ORGANIZATION"],
                        "URL" => $arResult['PATH_TEMPLATE'],
//                        "AJAX_MODE" => "Y",
//                        "AJAX_OPTION_ADDITIONAL" => "",
//                        "AJAX_OPTION_HISTORY" => "N",
//                        "AJAX_OPTION_JUMP" => "N",
//                        "AJAX_OPTION_STYLE" => "Y",
                        "URL_MENU" => array(
                            array(
                                "URL" => $arResult["PATH_TEMPLATE"]["URL_TEMPLATES_INDEX"],
                                "NAME" => "Личные данные"
                            ),
                            array(
                                "URL" => $arResult["PATH_TEMPLATE"]["URL_TEMPLATES_ORGANIZATION-INFO"],
                                "NAME" => "Данные организации"
                            ),
                        )
                    )
                );
                ?></div><?
                break;
        }
        ?>
    </div>
</div>