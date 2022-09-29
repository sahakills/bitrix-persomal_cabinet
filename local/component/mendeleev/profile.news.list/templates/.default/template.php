<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
    if (!empty($arResult["ITEMS"])) :
        ?>
        <div class="news-cards__items">
            <?
                foreach ($arResult["ITEMS"] as $arItem) :
                    ?>
                    <div class="news-card-item" id="news-card-item-<?=$arItem["ID"]?>">
                        <div class="item-video">
                        <? if (!empty($arItem["PREVIEW_PICTURE"])) :?>

                                    <img class="video-link" src="<?=$arItem["PREVIEW_PICTURE"]?>">
                            <? endif; ?>
                        </div>
                        <div class="item-content">
                            <div class="content-header"><?=$arItem["NAME"]?></div>
                            <div class="content-box">
                                <div class="content-author"><?=$arItem["USER_NAME"]?></div>
                                <div class="content-button">
                                    <a class="content-button-edit" href="<?=$arItem["EDIT_LINK"]?>">Редактировать</a>
                                    <? if ($arParams["ARCHIVE"] === "Y"): ?>
                                        <a data-id="<?=$arItem["ID"]?>" class="content-button-archiv">В архив</a>
                                    <?endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?
            endforeach;
            ?>
        </div>
    <?
endif;
?>