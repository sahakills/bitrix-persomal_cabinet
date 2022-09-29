<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
$APPLICATION->IncludeComponent(
    "mendeleev:profile.menu.inner.section",
    "",
    array(
        "IBLOCK_ID" => $arParams["IBLOCK_NEWS"],
        "CURRENT_SECTION" => $arParams["SECTION_ID"],
        "ARCHIVE" => $arParams["ARCHIVE"],
        "URL_MENU_ARCHIVE" => $arParams["URL"]["URL_TEMPLATES_NEWS_ARCHIVE"],
        "URL_MENU_SECTION" => $arParams["URL_MENU_SECTION"],
    )
);
?>
<div class="row profile-view-wrap services news-add-element">
    <div class="services-box">
        <div class="header-h3">Редактирование</div>
        <? if ($arResult["ERROR"]) : ?>
            <p class="errortext"><?= $arResult["ERROR"] ?></p>
        <? endif;
        if ($arResult["SUCCESS"]) :
            ?>
            <p class="success"><?= $arResult["SUCCESS"] ?></p>
        <? endif; ?>
        <form method="POST" action="<?= $APPLICATION->GetCurPage() ?>" enctype="multipart/form-data"
              class="validate-form news-add__form">
            <div class="view-item-services">
                <div class="form-info-registration">
                    <div class="form__clone-container">
                        <div class="form-row">
                            <label class="item-label">Заголовок новости*</label>
                            <input required data-error-target="element-TITLE" type="text" id="element-TITLE" name="TITLE" placeholder="Заголовок новости*" value="<?=$arResult["FIELDS"]["NAME"]?>">
                            <span class="form-row-error-wrap" id="element-TITLE">Необходимо ввести заголовок</span>
                        </div>
                        <div class="form-row">
                            <label class="item-label">ФИО эксперта</label>
                            <input type="text" name="SPEAKER[NAME]" placeholder="ФИО эксперта" value="<?=$arResult["PROPERTY"]["SPEAKER_ITEM"]["FIELDS"]["NAME"]?>">
                        </div>
                        <div class="form-row">
                            <label class="item-label">Должность эксперта</label>
                            <input type="text" name="SPEAKER[POSITION]" placeholder="Должность эксперта" value="<?=$arResult["PROPERTY"]["SPEAKER_ITEM"]["PROPERTY"]["POSITION"]["VALUE"]?>">
                        </div>
                        <input type="hidden" name="SPEAKER[ID]" value="<?=$arResult["PROPERTY"]["SPEAKER_ITEM"]["FIELDS"]["ID"]?>">
                        <div class="form-row">
                            <label class="item-label">Формат видео</label>
                            <select class="select search_block-form-category" name="TAG_LIST[]" placeholder="Формат видео">
                                <? if ($arResult["PROPERTY"]["TAG_LIST"]["VALUE_ENUM_ID"]): ?>
                                    <option selected value="<?=$arResult["PROPERTY"]["TAG_LIST"]["VALUE_ENUM_ID"]?>"><?=$arResult["PROPERTY"]["TAG_LIST"]["VALUE"]?></option>
                                <?endif;?>
                                <? foreach ($arResult['PROP_LIST_TAG'] as $arProp) : ?>
                                    <option value="<?=$arProp["ID"]?>"><?=$arProp["VALUE"]?></option>
                                <?endforeach;?>
                            </select>
                        </div>
                        <div class="form-row">
                            <label class="item-label">Описание видео*</label>
                            <?php
                            $APPLICATION->IncludeComponent(
                                "mendeleev:tinymce",
                                "",
                                array(
                                    "TEXT" => $arResult["FIELDS"]["DETAIL_TEXT"],
                                    "TEXTAREA_ID" => "text-detail",         // id поля
                                    "TEXTAREA_NAME" => "text-detail", // имя поля
                                    "TEXTAREA_PLACEHOLDER" => "Описание видео*",
                                    "REQUIRED" => 'Y',
                                    "MSG_ERROR" => "Необходимо описание видео"
                                ),
                                false
                            );
                            ?>
                        </div>


                        <label class="item-label">Превью видео*</label>
                        <div class="output-photo-file">
                            <? if (!empty($arResult["FIELDS"]["PREVIEW_PICTURE"])):?>
                                <img src="<?=$arResult["FIELDS"]["PREVIEW_PICTURE"]["SRC"]?>" width="250" alt="<?=$arResult["FIELDS"]["PREVIEW_PICTURE"]["ORIGINAL_NAME"]?>">
                                <span class="output-photo-file-name">
                                    <?=$arResult["FIELDS"]["PREVIEW_PICTURE"]["ORIGINAL_NAME"]?>
                                </span>
                                <div class="output-photo-file-icon-del">
                                    <i class="icon icon-trash"></i>
                                </div>
                            <? endif;?>
                        </div>
                        <div class="news-add-photo">
                            <div class="photo-element">
                                <? if (!empty($arResult["FIELDS"]["PREVIEW_PICTURE"])): ?>
                                    <input type="hidden" name="old_preview" value="<?=$arResult["FIELDS"]["PREVIEW_PICTURE"]["ID"]?>">
                                <?endif;?>
                                <input id="file-input" type="file" value="<?=$arResult["FIELDS"]["PREVIEW_PICTURE"]["ID"]?>"  name="detail-picture">
                                <label for="file-input" class="photo-back-text">Выберите файлы для загрузки или
                                    перетащите их в данную область</label>
                                <svg width="18" height="20" viewBox="0 0 18 20" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12 2H2V18H16V6H12V2ZM0 0.992C0 0.444 0.447 0 0.999 0H13L18 5V18.993C18.0009 19.1243 17.976 19.2545 17.9266 19.3762C17.8772 19.4979 17.8043 19.6087 17.7121 19.7022C17.6199 19.7957 17.5101 19.8701 17.3892 19.9212C17.2682 19.9723 17.1383 19.9991 17.007 20H0.993C0.730378 19.9982 0.479017 19.8931 0.293218 19.7075C0.107418 19.5219 0.00209465 19.2706 0 19.008V0.992ZM10 10V14H8V10H5L9 6L13 10H10Z"
                                        fill="#9BB3E3"/>
                                </svg>
                            </div>
                            <div class="photo-size-recommended">Оптимальный размер изображения 700*350</div>
                        </div>
                        <div class="form-row">
                            <label class="item-label">Ссылка на видео</label>
                            <input required data-error-target="link_video" type="text" name="link_video" placeholder="Ссылка на видео" value="<?=$arResult["PROPERTY"]["VIDEO"]["VALUE"]?>">
                            <span class="error-input-message" id="link_video">Необходимо указать ссылку на видео</span>
                        </div>
                    </div>
                    <div class="profile-view-wrap-footer">
                        <div class="profile-view-wrap-footer-row">
                            <?= bitrix_sessid_post() ?>
                            <input type="hidden" name="add-elements" value="Сохранить">
                            <input type="submit" class="btn btn_register" value="Сохранить">
                            <a href="<?=$arParams["URL"]["URL_TEMPLATES_HOBBY"]?>" class="btn-text">Отменить</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>