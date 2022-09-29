<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<div class="news-wrapper">
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
            <div class="header-h3"><?=($arResult["SECTION_INFO"]["UF_TEMPLATE_NAME_HEADER"]) ? $arResult["SECTION_INFO"]["UF_TEMPLATE_NAME_HEADER"] : "Добавление раздела"?></div>
            <?
            if ($arResult["ERROR"]) :
            ?>
                <p class="errortext"><?= $arResult["ERROR"] ?></p>
            <?
            endif;
            if ($arResult["SUCCESS"]) :
            ?>
                <p class="success"><?= $arResult["SUCCESS"] ?></p>
            <?
            endif;
            ?>
            <form method="POST" action="<?= $APPLICATION->GetCurPage() ?>" enctype="multipart/form-data" class="validate-form news-add__form">
                <div class="view-item-services">
                    <div class="form-info-registration">
                        <div class="form__clone-container">
                            <div class="form-row">
                                <label class="item-label">Наименование видео*</label>
                                <input required data-error-target="element-TITLE" type="text" name="element[TITLE][]" placeholder="Заголовок раздела*">
                                <span class="error-input-message" id="element-TITLE">Необходимо ввести наименование видео</span>
                            </div>
                            <div class="form-row">
                                <label class="item-label">ФИО эксперта</label>
                                <input type="text" name="element[SPEAKER][NAME][]" placeholder="ФИО эксперта">
                            </div>
                            <div class="form-row">
                                <label class="item-label">Должность эксперта</label>
                                <input type="text" name="element[SPEAKER][POSITION][]" placeholder="Должность эксперта">
                            </div>
                            <div class="form-row">
                                <label class="item-label">Формат видео</label>
                                <select class="select search_block-form-category" name="TAG_LIST[]" placeholder="Формат раздела">
                                    <option disabled>Формат раздела</option>
                                    <? foreach ($arResult['PROP_LIST_TAG'] as $arProp) : ?>
                                        <option value="<?=$arProp["ID"]?>"><?=$arProp["VALUE"]?></option>
                                    <?endforeach;?>
                                </select>
                            </div>
                            <div class="form-row">
                                <label class="item-label">Описание к видео*</label>
                                <?php
                                    $APPLICATION->IncludeComponent(
                                        "mendeleev:tinymce",
                                        "",
                                        array(
                                            "TEXTAREA_ID" => "element_text-detail",         // id поля
                                            "TEXTAREA_NAME" => "element_text-detail", // имя поля
                                            "TEXTAREA_PLACEHOLDER" => "Описание к видео*",
                                            "REQUIRED" => "N",
                                            "MSG_ERROR" => "Необходимо указать анонс новости"
                                        ),
                                        false
                                    );
                                ?>

                            </div>
                            <label class="item-label">Превью видео*</label>
                            <div class="output-photo-file">
                            </div>
                            <div class="news-add-photo">
                                <div class="photo-element">

                                    <input id="file-input" type="file" name="detail-picture[]">
                                    <label for="file-input" class="photo-back-text">Выберите файлы для загрузки или перетащите их в данную область</label>
                                    <svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 2H2V18H16V6H12V2ZM0 0.992C0 0.444 0.447 0 0.999 0H13L18 5V18.993C18.0009 19.1243 17.976 19.2545 17.9266 19.3762C17.8772 19.4979 17.8043 19.6087 17.7121 19.7022C17.6199 19.7957 17.5101 19.8701 17.3892 19.9212C17.2682 19.9723 17.1383 19.9991 17.007 20H0.993C0.730378 19.9982 0.479017 19.8931 0.293218 19.7075C0.107418 19.5219 0.00209465 19.2706 0 19.008V0.992ZM10 10V14H8V10H5L9 6L13 10H10Z" fill="#9BB3E3" />
                                    </svg>
                                </div>
                                <div class="photo-size-recommended">Оптимальный размер изображения 700*350</div>
                            </div>
                            <div class="form-row">
                                <label class="item-label">Ссылка на видео</label>
                                <input data-error-target="link_video" type="text" name="element[link_video][]" placeholder="Ссылка на видео">
                                <span class="error-input-message" id="link_video">Необходимо указать ссылку на видео</span>
                            </div>
                        </div>
                        <div class="profile-view-wrap-footer">
                            <div class="profile-view-wrap-footer-row">
                                <?= bitrix_sessid_post() ?>
                                <input type="hidden" name="add-elements" value="Сохранить">
                                <input type="submit" class="btn btn_register" value="Сохранить">
                                <a href="<?=$arResult["SECTION_INFO"]["LINK_BACK"]?>" class="btn-text">Отменить</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>