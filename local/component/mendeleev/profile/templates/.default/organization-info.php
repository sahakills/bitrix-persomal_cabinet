<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
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
            <?php
            $APPLICATION->IncludeComponent(
                "mendeleev:profile.menu.inner.index",
                "",
                array(
                    "AR_URL" => array(
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
            ?>

            <div class="row profile-view-wrap employees">
                <? if ($arResult["ORGANIZATION"]["MODERATION"]) :?>
                    <div class="profile__form">
                        <div class="view-item-organization">
                            <label class="form-header">Данные организации</label>
                            <div class="form-info-registration">
                                <div class="form-row">
                                    <label class="item-label">ИНН</label>
                                    <input disabled type="text" placeholder="ИНН*" value="<?=$arResult["ORGANIZATION"]["PROPERTY"]["INFO_INN"]["VALUE"]?>">
                                </div>
                                <div class="form-row">
                                    <label class="item-label">Полное наименование организации</label>
                                    <input disabled type="text" placeholder="Полное наименование организации" value="<?=$arResult["ORGANIZATION"]["NAME"]?>">
                                </div>
                                <div class="form-row">
                                    <label class="item-label">Краткое наименование организации</label>
                                    <input disabled type="text" placeholder="Краткое наименование организации" value="<?= $arParams["ORGANIZATION"]["PROPERTY"]["SHORT_NAME"]["VALUE"] ?>">
                                </div>
                                <div class="form-row">
                                    <label class="item-label">Cвидетельство о регистрации (номер)</label>
                                    <input disabled type="text" name="numberRegistration" placeholder="Cвидетельство о регистрации (номер)*" value="<?=$arResult["ORGANIZATION"]["PROPERTY"]["INFO_REG"]["VALUE"]?>">
                                </div>
                                <div class="form-row">
                                    <label class="item-label">Категория*</label>
                                    <input disabled type="text" placeholder="категория" value="<?=$arResult["ORGANIZATION"]["PROPERTY"][""]["VALUE"]?>">
                                </div>
                                <div class="form-row">
                                    <label class="item-label">Основное направление</label>
                                    <input disabled type="text" placeholder="Основное направление" value="<?=$arResult["ORGANIZATION"]["PROPERTY"][""]["VALUE"]?>">
                                </div>
                                <div class="form-row">
                                    <label class="item-label">Адрес организации</label>
                                    <? if ($arResult["ORGANIZATION"]["PROPERTY"]["ADDRESS"]["VALUE"]) :
                                        foreach ($arResult["ORGANIZATION"]["PROPERTY"]["ADDRESS"]["VALUE"] as $sValue) :
                                            ?>
                                        <input disabled type="text" placeholder="" value="<?=$sValue?>">

                                        <? endforeach;?>
                                    <?else: ?>
                                        <input disabled type="text" placeholder="Адрес организации">
                                    <? endif;?>
                                </div>
                                <div class="form-row">
                                    <label class="item-label">Координаты на карте</label>
                                    <? if ($arResult["ORGANIZATION"]["PROPERTY"]["ADDRESS_MARK"]["VALUE"]) :
                                        foreach ($arResult["ORGANIZATION"]["PROPERTY"]["ADDRESS_MARK"]["VALUE"] as $sValue) :
                                            ?>
                                            <input disabled type="text" placeholder="" value="<?=$sValue?>">

                                        <? endforeach;?>
                                    <?else: ?>
                                        <input disabled type="text" placeholder="Координаты на карте">
                                    <? endif;?>
                                </div>
                                <div class="form-row">
                                    <label class="item-label">Номер телефона организации</label>
                                    <? if ($arResult["ORGANIZATION"]["PROPERTY"]["PHONE"]["VALUE"]) :
                                        foreach ($arResult["ORGANIZATION"]["PROPERTY"]["PHONE"]["VALUE"] as $sValue) :
                                            ?>
                                            <input disabled type="text" placeholder="" value="<?=$sValue?>">

                                        <? endforeach;?>
                                    <?else: ?>
                                        <input disabled type="text" placeholder="Номер телефона организации">
                                    <? endif;?>
                                </div>
                                <div class="form-row">
                                    <label class="item-label">Email организации</label>
                                    <? if ($arResult["ORGANIZATION"]["PROPERTY"]["EMAIL"]["VALUE"]) :
                                        foreach ($arResult["ORGANIZATION"]["PROPERTY"]["EMAIL"]["VALUE"] as $sValue) :
                                            ?>
                                            <input disabled type="text" placeholder="Email организации" value="<?=$sValue?>">

                                        <? endforeach;?>
                                    <?else: ?>
                                        <input disabled type="text" placeholder="Email организации">
                                    <? endif;?>
                                </div>
                                <div class="form-row">
                                    <label class="item-label">Адрес сайта организации</label>
                                    <? if ($arResult["ORGANIZATION"]["PROPERTY"]["LINK_SITE"]["VALUE"]) :
                                        foreach ($arResult["ORGANIZATION"]["PROPERTY"]["LINK_SITE"]["VALUE"] as $sValue) :
                                            ?>
                                            <input disabled type="text" placeholder="Адрес сайта организации" value="<?=$sValue?>">

                                        <? endforeach;?>
                                    <?else: ?>
                                        <input disabled type="text" placeholder="Адрес сайта организации">
                                    <? endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <? else: ?>
                        <div class="header-h3">Компания находится на модерации</div>
                    <?endif;?>
            </div>
        </div>
    </div>
</div>