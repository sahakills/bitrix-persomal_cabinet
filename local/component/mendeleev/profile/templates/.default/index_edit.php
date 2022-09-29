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
        <?php
        switch ($arResult['USER']['USER_TYPE']) {
            case "default":
                $APPLICATION->IncludeComponent(
                    "mendeleev:profile.user.edit",
                    "",
                    array(
                        "MSG_EVENT" => "PERSONAL_COFIRM_EMAIL",
                        "PATH_CONFIRM_EMAIL" => "/login/confirm-email/"
                    )
                );
                break;
            default:
                ?><div class="tabs col-lg-8 profile-view"><?
                $APPLICATION->IncludeComponent(
                    "mendeleev:profile.user.type.edit",
                    "",
                    array(
                        "MSG_EVENT" => "PERSONAL_COFIRM_EMAIL",
                        "PATH_CONFIRM_EMAIL" => "/login/confirm-email/"
                    )
                );
                ?></div><?
                break;
        }
        ?>
    </div>
</div>