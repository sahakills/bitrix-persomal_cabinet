<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

    <div class="col-lg-8 profile-view" >
    <?php if (empty($arResult["ERROR"])) :?>
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
                    <?
                    foreach ($arResult["LIST_SECTION"] as $intKey => $arSection) :
                        ?>
                        <?=($arSection["ID"] == $arParams["SECTION_ID"])? $arSection["NAME"] : ""?>
                    <?
                    endforeach;
                    ?>
                </div>
                <?

                $APPLICATION->IncludeComponent(
                    "mendeleev:profile.news.list",
                    "archive",
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
    <?php else :?>
        <div class="row profile-view-wrap news">
            <div class="news-box">
                <div class="header-h3">
                    <?=$arResult["ERROR"]["MESSAGE"]?>
                </div>
            </div>
        </div>
    <? endif; ?>
</div>
