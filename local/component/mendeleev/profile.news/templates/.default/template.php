<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class=" tabs col-lg-8 profile-view">
    <?php if (empty($arResult["ERROR"])) : ?>
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
        <div class="row profile-view-wrap news">
            <div class="news-box">
                <div class="header-h3">
                    <?=$arResult["LIST_TITLE"]?>
                </div>
                <? if (!empty($arResult["LINK_ADD"])) :?>
                    <div class="button-news-add">
                        <a class="btn btn_register" href="<?= $arResult["LINK_ADD"] ?>">
                            <?=$arResult["LIST_TITLE_BTN"]?>
                        </a>
                    </div>
                <? endif; ?>
                <?
                $APPLICATION->IncludeComponent(
                    "mendeleev:profile.news.list",
                    $arResult["TEMPLATE_ITEM_LIST"],
                    array(
                        "ORGANIZATION" => $arParams["ORGANIZATION"],
                        "IBLOCK_ID" => $arParams["IBLOCK_NEWS"],
                        "URL" => $arParams["URL"],
                        "TITLE" => $arSection["NAME"],
                        "SECTION_ID" => $arParams["SECTION_ID"],
                        "FIELDS" => array(
                            "ID",
                            "NAME",
                            "USER_NAME",
                            "IBLOCK_SECTION_ID",
                            "PREVIEW_TEXT",
                            "PREVIEW_PICTURE",
                            "DETAIL_TEXT",
                            "DATE_CREATE",
                            "CREATED_BY"
                        ),
                        "PROPERTIES" => array(
                            "EVENTS_PLACE",
                            "EVENTS_TIME",
                            "SPEAKER_ITEM",
                            "VIDEO"
                        ),
                        "FILTER" => $arParams["FILTER"],
                        "URL_EDIT_ITEM" => $arParams["URL_EDIT_ITEM"],
                        "ARCHIVE" => $arParams["ARCHIVE"],
                    )
                );
                ?>
            </div>
        </div>
    <?php else : ?>
        <div class="row profile-view-wrap news">
            <div class="news-box">
                <div class="header-h3">
                    <?= $arResult["ERROR"]["MESSAGE"] ?>
                </div>
            </div>
        </div>
    <? endif; ?>
</div>