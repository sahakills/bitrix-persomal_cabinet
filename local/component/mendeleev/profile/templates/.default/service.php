<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php
//mpr($arResult , false);
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
        //проверка прав к разделу
        //услуги в организации разбить по категориям
        //получить всю инфу из услуги

        $APPLICATION->IncludeComponent(
            "mendeleev:profile.service",
            "",
            array(
                "USER" => $arResult["USER"],
                "ORGANIZATION" => $arResult["ORGANIZATION"],
                "URL" => $arResult["PATH_TEMPLATE"],
                "IBLOCK_SERVICE" => $arParams["IBLOCK_SERVICE"],
                "RIGHT_SERVICE" => $arParams["RIGHT_SERVICE"]
            )
        );
        ?>

    </div>
</div>