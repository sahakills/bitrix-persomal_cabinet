<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<style>
    .edit-service-page {
        width: 120%;
    }

    .edit-service-page .services-button-container {
        flex-direction: column;
    }
</style>
<div class="row profile-view-wrap services services-edit">
    <div class="services-box add-service-page">

        <? if (empty($arResult["ERROR"])) : ?>
            <div class="header-h3">Редактирование услуг</div>
            <form method="post" action="<?= $APPLICATION->GetCurPage() ?>" class="validate-form services__form add-service-page">
                <div class="view-item-services">
                    <div class="form-info-registration">
                        <div class="form__clone-container">
                            <label class="item-label">Направление</label>
                            <div class="form-row">
                                <select class="select search_block-form-category" id="ajax-service-elements" placeholder="Новое направление">
                                    <? if (empty($arResult["DIRECTION"])): ?>
                                        <option disabled selected value="0">Новое направление</option>
                                    <? endif;?>
                                    <? if ($arResult["DIRECTION"]) :
                                        foreach ($arResult["DIRECTION"] as $arValue) :
                                    ?>
                                            <option <?= ($arValue["ID"] == $arParams["URL"]["SECTION_ID"]) ? "selected" : "" ?> value="<?= $arValue["ID"] ?>"><?= $arValue["NAME"] ?></option>
                                    <?
                                        endforeach;
                                    endif;
                                    ?>
                                </select>
                            </div>
                            <label class="item-label">Услуга</label>
                            <div class="form-row">
                                <select data-error-target="service-child-select-elements" class="select search_block-form-provider" id="service-child-section" required name="PROPERTY[1]" placeholder="Услуга">
                                    <? if (empty($arResult["LIST_SERVICE"])): ?>
                                        <option disabled selected value="0">Услуга</option>
                                    <?endif;?>
                                    <?
                                    foreach ($arResult["LIST_SERVICE"] as $arValue) :
                                    ?>
                                        <option <?= ($arValue["ID"] == $arResult["CURRENT_PROP"][1]) ? "selected" : "" ?> value="<?= $arValue["ID"] ?>"><?= $arValue["NAME"] ?></option>
                                    <?
                                    endforeach;
                                    ?>
                                </select>
                                <span class="error-input-message" id="service-child-select-elements">Необходимо выбрать услугу</span>
                            </div>
                            <div class="form-row">
                                <label class="item-label">Группа инвалидности</label>
                                <div class="services__direction-items select-wrapper">
                                    <div class="direction-input-item list-invalid-gi">
                                        <input type="text" value="<?=(!empty($arResult["SELECTED_LIST_GI"])? implode(', ' , $arResult["SELECTED_LIST_GI"]) : "Группа инвалидности")?>" title="Группа инвалидности" >
                                    </div>
                                    <ul class="direction-list-item providing list-invalid-gi select-container">
                                        <div class="scroll-list-item valid-checkbox-multiple" data-error-target="LIST_GI" data-error-wraper="LIST_GI_wrap-error">
                                            <? foreach ($arResult["LIST_GI"] as $arValue) : ?>
                                                <li class="list-item-text" data-value="<?= $arValue["ID"]; ?>">
                                                    <input <?= (in_array($arValue["ID"], $arResult["CURRENT_PROP"][2])) ? "checked" : "" ?> name="PROPERTY[2][]" type="checkbox" value="<?= $arValue["ID"] ?>" id="cb-status-in<?= $arValue["ID"] ?>" data-value-name="<?= $arValue["UF_HL_NAME_PROP"]; ?>">
                                                    <label for="cb-status-in<?= $arValue["ID"] ?>"><?= $arValue["UF_HL_NAME_PROP"] ?></label>
                                                </li>
                                            <? endforeach; ?>
                                        </div>
                                    </ul>
                                </div>
                                <span class="error-input-message" id="LIST_GI">Необходимо указать группу инвалидности</span>
                            </div>
                            <div class="form-row">
                                <label class="item-label">Категория инвалидности</label>
                                <div class="services__direction-items select-wrapper">
                                    <div class="direction-input-item list-invalid-categoria">
                                        <input type="text" value="<?=(!empty($arResult["SELECTED_LIST_KI"])? implode(', ' , $arResult["SELECTED_LIST_KI"]) : "Категория инвалидности")?>" title="Категория инвалидности">
                                    </div>
                                    <ul class="direction-list-item providing list-invalid-categoria select-container">
                                        <div class="scroll-list-item valid-checkbox-multiple" data-error-target="LIST_KI" data-error-wraper="LIST_KI_wrap-error">
                                            <? foreach ($arResult["LIST_KI"] as $arValue) : ?>
                                                <li class="list-item-text" data-value="<?= $arValue["ID"]; ?>">
                                                    <input <?= (in_array($arValue["ID"], $arResult["CURRENT_PROP"][4])) ? "checked" : "" ?> name="PROPERTY[4][]" type="checkbox" value="<?= $arValue["ID"] ?>" id="cb-status-ink<?= $arValue["ID"] ?>" data-value-name="<?= $arValue["UF_HL_PROPACCESS"]; ?>">
                                                    <label for="cb-status-ink<?= $arValue["ID"] ?>"><?= $arValue["UF_HL_PROPACCESS"] ?></label>
                                                </li>
                                            <? endforeach; ?>
                                        </div>
                                    </ul>
                                </div>
                                <span class="error-input-message" id="LIST_KI">Необходимо указать категорию инвалидности</span>
                            </div>
                            <div class="form-row">
                                <label class="item-label">Район</label>
                                <div class="services__direction-items select-wrapper">
                                    <div class="direction-input-item list-city">
                                        <input type="text" value="<?=(!empty($arResult["SELECTED_LIST_CITY"])? implode(', ' , $arResult["SELECTED_LIST_CITY"]) : "Район")?>" title="Район">
                                    </div>
                                    <ul class="direction-list-item providing list-city select-container">
                                        <div class="scroll-list-item valid-checkbox-multiple" data-error-target="LIST_CITY" data-error-wraper="LIST_CITY_wrap-error">
                                            <? foreach ($arResult["LIST_CITY"] as $arValue) : ?>
                                                <li class="list-item-text" data-value="<?= $arValue["ID"]; ?>">
                                                    <input <?= (in_array($arValue["ID"], $arResult["CURRENT_PROP"][6])) ? "checked" : "" ?> name="PROPERTY[6][]" type="checkbox" value="<?= $arValue["ID"] ?>" id="cb-status-city<?= $arValue["ID"] ?>" data-value-name="<?= $arValue["NAME"]; ?>">
                                                    <label for="cb-status-city<?= $arValue["ID"] ?>"><?= $arValue["NAME"] ?></label>
                                                </li>
                                            <? endforeach; ?>
                                        </div>
                                    </ul>
                                </div>
                                <span class="error-input-message" id="LIST_CITY">Необходимо выбрать район</span>
                            </div>
                            <div class="form-row">
                                <label class="item-label">Стоимость услуги</label>
                                <div class="checkbox">
                                    <div class="checkbox-items valid-checkbox-multiple" data-error-target="LIST_PRICE">
                                    <?
                                    foreach ($arResult["LIST_PRICE"] as $arValue) :
                                    ?>
                                        <label for="pricerb_<?= $arValue["ID"] ?>" class="checkbox-controller-label">
                                            <input <?= (in_array($arValue["ID"], $arResult["CURRENT_PROP"][5])) ? "checked" : "" ?> class="checkbox-controller-input" type="checkbox" value="<?= $arValue["ID"] ?>" name="PROPERTY[5][<?= $arValue["ID"]; ?>]" id="pricerb_<?= $arValue["ID"] ?>">
                                            <div class="checkbox-controller"></div>
                                            <span class="checkbox-controller-text"><?= $arValue["UF_PROPPAY"] ?></span>
                                        </label>
                                    <?
                                    endforeach;
                                    ?>
                                    </div>
                                </div>
                                <span class="error-input-message" id="LIST_PRICE">Необходимо выбрать стоимость услуги</span>
                            </div>
                        </div>
                        <div class="profile-view-wrap-footer">
                            <div class="profile-view-wrap-footer-row">
                                <?= bitrix_sessid_post() ?>
                                <input type="submit" class="btn btn_register" name="update_service" value="Сохранить">
                                <a href="<?=$arParams["URL"]["URL_TEMPLATES_SERVICE"]?>" class="btn-text">Отменить</a>
                            </div>
                            <div class="profile-view-wrap-footer-row">
                                <input type="submit" class="btn-text" name="services-button-delete" value="Удалить услугу">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <? else : ?>
            <div class="header-h3"><?= $arResult["ERROR"]["MESSAGE"] ?></div>
        <? endif; ?>
    </div>
</div>