<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

$APPLICATION->IncludeComponent(
    "mendeleev:profile.menu.inner.index",
    "",
    array(
        "AR_URL" => $arParams["URL_MENU"]
    )
);
?>

<div class="row profile-view-wrap">
    <div class="header-h3"><?=$arParams["ORGANIZATION"]["NAME"] ?></div>
    <?
    if (!$arParams["ORGANIZATION"]["MODERATION"]) :
        ?>
        <span class="profile-error-message-head">Организация на модерации</span>
    <?
    endif;
    ?>
    <form id="form-edit-organization" method="post" enctype="multipart/form-data" action="<?= $APPLICATION->GetCurPage() ?>" class="validate-form profile__form personal-content">
        <div class="view-item-company">
            <label class="form-header">Данные контактного лица</label>
            <div class="form-info-registration">
                <div class="form-row">
                    <label class="item-label" for="fio">ФИО контактного лица</label>
                    <input disabled type="text" id="fio" name="fio" placeholder="" value="<?= $arParams["USER"]["NAME"] ?>">
                </div>
                <div class="form-row">
                    <label class="item-label" for="tel">Номер телефона контактного лица*</label>
                    <input disabled type="text" id="tel" name="tel" placeholder="Номер телефона контактного лица" value="<?= $arParams["USER"]["PERSONAL_PHONE"] ?>">
                </div>
                <div class="form-row">
                    <label class="item-label" for="email">Email</label>
                    <input disabled type="text" id="email" name="email" placeholder="Номер телефона контактного лица" value="<?= $arParams["USER"]["EMAIL"] ?>">
                </div>
            </div>
        </div>
        <div class="view-item-organization">
            <label class="form-header">Данные организации</label>
            <div class="form-info-registration">
                <div class="form-row">
                    <label class="item-label" for="full_name_org_input">Полное наименование организации*</label>
                    <input required type="text" data-error-target="full_name_org" id="full_name_org_input" name="FIELDS[NAME]" placeholder="" value="<?= $arParams["ORGANIZATION"]["NAME"] ?>">
                    <span class="error-input-message" id="full_name_org">Необходимо ввести полное наименование организации</span>
                </div>
                <div class="form-row">
                    <label class="item-label" for="short_name_org">Краткое наименование организации</label>
                    <input type="text" id="short_name_org" name="PROPERTY[SHORT_NAME]" placeholder="Краткое наименование организации" value="<?= $arParams["ORGANIZATION"]["PROPERTY"]["SHORT_NAME"]["VALUE"] ?>">
                </div>
                <div class="form-row">
                    <label class="item-label" for="info_inn">ИНН*</label>
                    <input required type="text" data-error-target="info_inn_error" id="info_inn" name="PROPERTY[INFO_INN]" placeholder="ИНН*" value="<?= $arParams["ORGANIZATION"]["PROPERTY"]["INFO_INN"]["VALUE"] ?>">
                    <span class="error-input-message" id="info_inn_error" >Необходимо ввести ИНН</span>
                </div>
                <div class="form-row form-row-fluid">
                    <label class="item-label" for="info_reg">Cвидетельство о регистрации (номер)*</label>
                    <div class="content-box-item">
                        <input type="text" id="info_reg" name="PROPERTY[INFO_REG]" placeholder="Cвидетельство о регистрации (номер)*" value="<?= $arParams["ORGANIZATION"]["PROPERTY"]["INFO_REG"]["VALUE"] ?>">
                        <input id="file-input-org" type="file" name="INFO_REG_PHOTO" style="display:none;">
                        <label for="file-input-org" class="insert-file">
                        </label>
                    </div>
                    <div class="output-file">
                        <? if ($arParams["ORGANIZATION"]["PROPERTY"]["INFO_REG_PHOTO"]["VALUE"] !== false): ?>
                            <p class="file-output-inner">документ: <?=$arParams["ORGANIZATION"]["PROPERTY"]["INFO_REG_PHOTO"]["VALUE"]["ORIGINAL_NAME"]?></p>
                        <?endif; ?>
                    </div>
                </div>
                <div class="form-row">
                    <label class="item-label">Направление деятельности*</label>
                    <select required data-error-target="section_1" class="select search_block-form-category" placeholder="Категория*" id="ajax-section">
                        <? if (!$arResult["ORGANIZATION_CATEGORY"]) : ?>
                            <option disabled selected value="0">Категория</option>
                        <? endif; ?>
                        <? foreach ($arResult["LIST_CATEGORY"] as $arValue) : ?>
                            <option <?= (in_array($arValue["ID"], $arResult["ORGANIZATION_CATEGORY"])) ? "selected" : "" ?> value="<?= $arValue["ID"] ?>"><?= $arValue["NAME"] ?></option>
                        <? endforeach; ?>
                    </select>
                    <span class="error-input-message" id="section_1">Необходимо выбрать направление деятельности</span>
                </div>
                <div class="form-row">
                    <label class="item-label">Основное направление*</label>
                    <div class="services__direction-items select-wrapper">
                        <div class="direction-input-item list-invalid-gi">
                            <input disabled type="text" value="<?=(!empty($arResult["CURRENT_DIRECTION"])? implode(', ' , array_column($arResult["CURRENT_DIRECTION"] , "NAME")) : "Основное направление")?>" title="Основное направление" id="direction-list_wrap-error">
                        </div>
                        <ul class="direction-list-item providing list-invalid-gi select-container">
                            <div class="scroll-list-item valid-checkbox-multiple" data-error-target="direction-list" data-error-wraper="direction-list_wrap-error" id="parent-section">
                                <? foreach ($arResult["LIST_DIRECTION"] as $arValue) : ?>
                                    <li class="list-item-text" data-value="<?= $arValue["ID"]; ?>">
                                        <input <?= ($arValue["SELECTED"] === true) ? "checked" : "" ?> name="FIELDS[SECTION][]" type="checkbox" value="<?= $arValue["ID"] ?>" id="checkbox-direction-<?= $arValue["ID"] ?>" data-value-name="<?= $arValue["NAME"]; ?>">
                                        <label for="checkbox-direction-<?= $arValue["ID"] ?>"><?= $arValue["NAME"] ?></label>
                                    </li>
                                <? endforeach; ?>
                            </div>
                        </ul>
                    </div>
                    <span class="error-input-message" id="direction-list">Необходимо указать группу инвалидности</span>
                </div>
                <div class="form-row">
                    <label class="item-label" for="adressOrg">Адрес организации*</label>
                    <? if ($arParams["ORGANIZATION"]["PROPERTY"]["ADDRESS"]["VALUE"]) :
                        foreach ($arParams["ORGANIZATION"]["PROPERTY"]["ADDRESS"]["VALUE"] as $value) :?>
                            <input type="text" id="adressOrg" name="PROPERTY[ADDRESS][]" placeholder="Адрес организации" value="<?= mb_substr($value, 0, 63) . ".."; ?>">
                    <?endforeach;?>
                        <input type="text" id="adressOrg" name="PROPERTY[ADDRESS][]" placeholder="Адрес организации">
                    <? else:?>
                        <input required data-error-target="adressOrgError" type="text" id="adressOrg" name="PROPERTY[ADDRESS][]" placeholder="Адрес организации">

                    <? endif; ?>
                    <span class="error-input-message" id="adressOrgError">Необходимо выбрать основное направление</span>
                </div>
                <div class="form-row form-row-fluid">
                    <label class="item-label" for="adress_mark">Координаты на карте*</label>
                    <?
                    if ($arParams["ORGANIZATION"]["PROPERTY"]["ADDRESS_MARK"]["VALUE"]) :
                        $countInput = 0;
                        foreach ($arParams["ORGANIZATION"]["PROPERTY"]["ADDRESS_MARK"]["VALUE"] as $intKey => $value) :
                            $arFieldsMapInput = array(
                                "INPUT_ID" => "adress_mark_" . $intKey,
                                "INPUT_NAME" => "PROPERTY[ADDRESS_MARK][]",
                                "INPUT_PLACEHOLDER" => "Координаты на карте",
                                "INPUT_VALUE" => $value,
                            );
                            if ($countInput == 0 ) {
                                $arFieldsMapInput["REQUIRED"] = "Y";
                            }
                            $APPLICATION->IncludeComponent(
                                "mendeleev:map.yandex.mark",
                                "",
                                $arFieldsMapInput
                            );
                        endforeach;
                        $APPLICATION->IncludeComponent(
                            "mendeleev:map.yandex.mark",
                            "",
                            array(
                                "INPUT_ID" => "adress_mark-new",
                                "INPUT_NAME" => "PROPERTY[ADDRESS_MARK][]",
                                "INPUT_PLACEHOLDER" => "Координаты на карте",
                            )
                        );
                    else:
                        $APPLICATION->IncludeComponent(
                            "mendeleev:map.yandex.mark",
                            "",
                            array(
                                "INPUT_ID" => "adress_mark-new",
                                "INPUT_NAME" => "PROPERTY[ADDRESS_MARK][]",
                                "INPUT_PLACEHOLDER" => "Координаты на карте",
                                "REQUIRED" => "Y",
                            )
                        );
                    endif;?>
                    <span class="error-input-message" id="yandex-new-mark">Необходимо выбрать координаты на карте</span>
                </div>
                <div class="form-row">
                    <label class="item-label" for="phone_org">Номер телефона организации*</label>
                    <? if ($arParams["ORGANIZATION"]["PROPERTY"]["PHONE"]["VALUE"]):
                        $countInput = 0;
                            foreach ($arParams["ORGANIZATION"]["PROPERTY"]["PHONE"]["VALUE"] as $value) : ?>
                            <input <?=($countInput == 0) ? "required data-error-target='phone_org_error'":""?> type="text" id="phone_org" class="input-phone-mask" name="PROPERTY[PHONE][]" placeholder="Номер телефона организации*" value="<?= $value ?>">
                            <? $countInput++;?>
                        <? endforeach;?>
                        <input type="text" id="phone_org" class="input-phone-mask" name="PROPERTY[PHONE][]" placeholder="Номер телефона организации">

                    <? else: ?>
                        <input required data-error-target="phone_org_error" type="text" id="phone_org" class="input-phone-mask" name="PROPERTY[PHONE][]" placeholder="Номер телефона организации*">
                    <? endif;?>
                    <span class="error-input-message" id="phone_org_error">Необходимо указать номер телефона</span>
                </div>
                <div class="form-row">
                    <label class="item-label" for="email_org">Email организации*</label>
                    <?  if ($arParams["ORGANIZATION"]["PROPERTY"]["EMAIL"]["VALUE"]) :
                        $countInput = 0;
                        foreach ($arParams["ORGANIZATION"]["PROPERTY"]["EMAIL"]["VALUE"] as $value) :?>
                            <input <?=($countInput == 0) ? "required data-error-target='email_org_error'":""?> type="text" id="email_org" name="PROPERTY[EMAIL][]" placeholder="Email организации*" value="<?= $value ?>" required>
                            <? $countInput++;?>
                        <? endforeach; ?>
                        <input type="text" id="email_org" name="PROPERTY[EMAIL][]" placeholder="Email организации*">
                    <? else: ?>
                        <input required data-error-target="email_org_error" type="text" id="email_org" name="PROPERTY[EMAIL][]" placeholder="Email организации*">
                    <? endif; ?>
                    <span class="error-input-message" id="email_org_error">Необходимо указать еmail организации</span>
                </div>
                <div class="form-row">
                    <label class="item-label" for="site_org">Адрес сайта организации</label>
                    <?  if ($arParams["ORGANIZATION"]["PROPERTY"]["LINK_SITE"]["VALUE"]) :
                        foreach ($arParams["ORGANIZATION"]["PROPERTY"]["LINK_SITE"]["VALUE"] as $value) :
                        ?>
                            <input type="text" id="site_org" name="PROPERTY[LINK_SITE][]" placeholder="Адрес сайта организации" value="<?= $value ?>">
                        <? endforeach;?>
                        <input type="text" id="site_org" name="PROPERTY[LINK_SITE][]" placeholder="Адрес сайта организации">

                    <? else:?>
                        <input type="text" id="site_org" name="PROPERTY[LINK_SITE][]" placeholder="Адрес сайта организации">
                    <? endif; ?>
                </div>
                <div class="form-row">
                    <label class="item-label" for="formАppeal">Форма обращения и перечень документов для получения услуги</label>
                    <?php
                    $APPLICATION->IncludeComponent(
                        "mendeleev:tinymce",
                        "",
                        array(
                            "TEXT" => $arParams["ORGANIZATION"]["PROPERTY"]["FORMA_SERVICE"]["VALUE"]["TEXT"], // контент из запроса который нужно вставить
                            "TEXTAREA_ID" => "PROPERTY_FORMA_SERVICE",         // id поля
                            "TEXTAREA_NAME" => "PROPERTY[FORMA_SERVICE]", // имя поля
                            "REQUIRED" => 'Y',
                            "MSG_ERROR" => "Необходимо заполнить форму обращения и перечень документов для получения услуг"
                        ),
                        false
                    );
                    ?>
                </div>
                <div class="button-check-send profile-modal-button">
                    <?= bitrix_sessid_post() ?>
                    <input type="hidden" name="AJAX_CALL" value="Y">
                    <input disabled class="btn btn_register" type="submit" name="updateOrganization" value="Отправить на проверку">
                </div>

            </div>
        </div>
    </form>
    <? if ($arResult["UPDATE_INFO"]): ?>
        <div class="jqm-modal jqm-modal-notice" id="modal-organization-result">
            <div class="close-modal close-jqm-modal"><svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M23.4375 6.5625L6.5625 23.4375" stroke="#3D454E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M23.4375 23.4375L6.5625 6.5625" stroke="#3D454E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <div class="modal-wrap-jqm">
                <div class="modal-container">
                    <div class="item-label">Ваши данные отправлены на проверку модератору. После проверки, вам будут доступны остальные разделы личного кабинета.</div>
                    <div class="modal-container-footer">
                        <input class="btn btn_register close-jqm-modal" type="button" value="Понятно">
                    </div>
                </div>
            </div>
        </div>
    <?endif;?>
</div>
