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
                                    <a class="content-button-recovery" data-id="<?=$arItem["ID"]?>" href="<?=$arItem["EDIT_LINK"]?>">Восстановить</a>
                                    <a class="open-modal-accept-del" data-modal="modal_news-<?=$arItem["ID"]?>">Удалить</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="jqm-modal jqm-modal-notice modal_news-<?=$arItem["ID"]?>" id="modal-confirm-delete">
                        <div class="close-modal"><svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M23.4375 6.5625L6.5625 23.4375" stroke="#3D454E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M23.4375 23.4375L6.5625 6.5625" stroke="#3D454E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <div class="modal-wrap-jqm">
                            <div class="modal-container">
                                <div class="modal-container-footer modal-content">
                                    <div class="item-label">Вы действительное хотите удалить материал ?</div>
                                    <div class="modal-container-footer">
                                        <button class="btn btn_register content-button-delete" data-id="<?=$arItem["ID"]?>">Удалить</button>
                                    </div>
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

