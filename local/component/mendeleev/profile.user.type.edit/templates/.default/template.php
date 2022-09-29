<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<div class="row profile-view-wrap security">
    <div class="header-h3">Безопасность</div>
    <div class="col-lg-8 profile-view-wrap-row profile-input">
        <? if ($arResult["UPDATE_EMAIL"]): ?>
            <span class="profile-view-msg-success"><?=$arResult["UPDATE_EMAIL"]?></span>
        <?endif;?>
        <? if ($arResult["ERROR_UPDATE_EMAIL"]):?>
            <span class="profile-view-msg-success"><?=$arResult["ERROR_UPDATE_EMAIL"]?></span>
        <? endif;?>
        <div class="profile-input-label">
            <div class="label-item-box">
                <div class="profile-view-wrap-row-label">Электронная почта</div>
                <div class="profile-view-wrap-row-value"><?=$USER->GetEmail()?></div>
            </div>
            <div class="profile-input-link">
                <a href="<?/*= $APPLICATION->GetCurPageParam('edit=true') */?>" class="edit-email">Изменить</a>
            </div>
        </div>
    </div>
    <div class="col-lg-8 profile__edit-email">
        <form method="post" action="<?=$APPLICATION->GetCurPage()?>" class="validate-form edit__email">
            <div class="form-row">
                <label class="item-label">Новый адрес</label>
                <input data-error-target="new_email" required type="text" name="USER[EMAIL]" placeholder="Новый адрес" value="<?=$_POST["USER"]["EMAIL"]?>">
                <span class="error-input-message" id="new_email">Необходимо ввести новый электронный адресс</span>
            </div>
            <div class="profile-view-wrap-footer">
                <div class="profile-view-wrap-footer-row">
                    <?= bitrix_sessid_post() ?>
                    <input name="user_change_email" type="submit" class="btn btn_register" value="Сохранить">
                    <input type="reset" class="btn-text edit-email-cancel-js" value="Отменить">
                </div>
            </div>
        </form>
    </div>
    <div class="col-lg-8 profile-view-wrap-row profile-input">
        <? if ($arResult["UPDATE_PASSWORD"]):?>
            <span class="profile-view-msg-success"><?=$arResult["UPDATE_PASSWORD"]?></span>
        <?endif;?>
        <div class="profile-input-label">
            <div class="label-item-box">
                <div class="profile-view-wrap-row-label">Пароль</div>
                <div class="profile-view-wrap-row-value">********</div>
            </div>
            <div class="profile-input-link">
                <a href="</*?= $APPLICATION->GetCurPageParam('edit=true') */?>" class="edit-password">Изменить</a>
            </div>
        </div>
    </div>
    <div class="col-lg-8 profile__edit-password">
        <form method="post" action="<?=$APPLICATION->GetCurPage()?>" class="edit__password validate-form" >
            <div class="form-row">
                <label class="item-label">Старый пароль</label>
                <input data-error-target="old_password" required type="password" name="USER[OLD_PASSWORD]" placeholder="Старый пароль">
                <span class="error-input-message" id="old_password">Необходимо ввести старый пароль</span>
            </div>
            <div class="form-row">
                <label class="item-label">Новый пароль</label>
                <input data-error-target="new_password" required type="password" name="USER[PASSWORD]" placeholder="Новый пароль" value="<?=$_POST["USER"]["PASSWORD"]?>">
                <span class="error-input-message" id="new_password">Необходимо ввести новый пароль</span>
            </div>
            <div class="form-row">
                <label class="item-label">Повторите пароль</label>
                <input data-error-target="new_password_confirm" required type="password" name="USER[CONFIRM_PASSWORD]" placeholder="Новый пароль" value="<?=$_POST["USER"]["CONFIRM_PASSWORD"]?>">
                <span class="error-input-message" id="new_password_confirm">Необходимо ввести пароль повторно</span>
            </div>
            <div class="profile-view-wrap-footer">
                <div class="profile-view-wrap-footer-row">
                    <?= bitrix_sessid_post() ?>
                    <input name="user_change_password" type="submit" class="btn btn_register" value="Сохранить">
                    <input type="reset" class="btn-text edit-password-cancel-js" value="Отменить">
                </div>
            </div>
        </form>
    </div>
</div>