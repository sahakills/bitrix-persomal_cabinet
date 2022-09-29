<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<div class="col-lg-8 profile-view">
    <? if (!empty($arResult["ERROR"])) :?>
        <div class="header-h3">
            <?=$arResult["ERROR"]?>
        </div>
    <?else: ?>
    <?
    $APPLICATION->IncludeComponent(
        "mendeleev:profile.menu.inner.index",
        "",
        array(
            "AR_URL" => $arParams["MENU_INDEX"]
        )
    );
    ?>
    <div class="show-archiv-modal jqm-modal jqm-modal-notice">
        <div class="close-modal"><svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M23.4375 6.5625L6.5625 23.4375" stroke="#3D454E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M23.4375 23.4375L6.5625 6.5625" stroke="#3D454E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
        <div class="modal-wrap-jqm">
            <div class="modal-container">
                <div class="header-h3">Укажите причину перемещения заявки в архив</div>
                <form method="post" action="/" class="modal__form form_send_item_to_archive" >
                    <div class="form-row">
                        <label class="item-label">Причина</label>
                        <input required type="text" name="textArchive" placeholder="Причина">
                    </div>
                    <div class="button-archiv-send modal--button">
                        <input type="submit" class="btn btn_register" value="Переместить">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row profile-view-wrap bid">
        <div class="bid-container">
            <div class="header-h3">Заявки</div>
            <? if ($arResult["ITEMS"]): ?>
            <div class="edit__bid">
                <div class="bid-container-label">
                    <div class="bid-label">
                        <label class="bid-label-item">Дата</label>
                        <label class="bid-label-item">Имя</label>
                        <label class="bid-label-item">Телефон</label>
                        <label class="bid-label-item">Комментарий</label>
                    </div>
                </div>
                <div class="bid-container-box">
                    <? foreach ($arResult["ITEMS"] as $arValue):?>
                        <div class="bid-container-box-item">
                            <div class="bid-container-box-item-info">
                                <div class="bid-container-box-item-info-title">
                                    <span class="bid-container-box-item-info-title-mobile">Дата</span>
                                    <?=$arValue["FIELDS"]["DATE_CREATE"]?>
                                </div>
                                <div class="bid-container-box-item-info-title">
                                    <span class="bid-container-box-item-info-title-mobile">Имя</span>
                                    <?=$arValue["FIELDS"]["NAME"]?></div>
                                <div class="bid-container-box-item-info-title">
                                    <span class="bid-container-box-item-info-title-mobile">Телефон</span>
                                    <?=$arValue["PROPERTY"]["PHONE"]["VALUE"]?>
                                </div>
                                <div class="bid-container-box-item-info-title">
                                    <span class="bid-container-box-item-info-title-mobile">Комментарий</span>
                                    <?=$arValue["FIELDS"]["DETAIL_TEXT"]?>
                                </div>
                                <div class="menu-burger">
                                    <ul>
                                        <?if ($arParams["TO_DONE"]):?>
                                            <li>
                                                <a class="add_to_done" data-id="<?=$arValue["FIELDS"]["ID"]?>">Переместить в исполненные</a>
                                            </li>
                                        <? endif;?>
                                        <?if ($arParams["TO_ARCHIVE"]):?>
                                            <li class="archiv-button">
                                                <a class="add_to_archive" data-id="<?=$arValue["FIELDS"]["ID"]?>">В архив</a>
                                            </li>
                                        <? endif;?>
                                    </ul>
                                </div>
                            </div>
                            <? if ($arValue["FIELDS"]["ACTIVE"] == "N") :?>
                                <div class="bid-container-box-item-commit">
                                    <p><?=$arValue["PROPERTY"]["COMMENTS"]["VALUE"]["TEXT"]?></p>
                                </div>
                            <? endif;?>
                        </div>
                    <? endforeach;?>
                </div>
            </div>
            <?endif;?>
        </div>
    </div>
    <?endif;?>
</div>