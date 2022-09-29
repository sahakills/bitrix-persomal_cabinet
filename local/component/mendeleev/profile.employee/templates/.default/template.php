<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<style>
    .col-lg-12 .row.profile-view-wrap {
        width: 100%;
    }

    .col-lg-12 .row.profile-view-wrap .profile__form {
        width: 85%;
    }
</style>
<?php
$APPLICATION->IncludeComponent(
    "mendeleev:profile.menu.inner.index",
    "",
    array(
        "AR_URL" => $arParams["URL_MENU"]
    )
);
?>
<div class="row profile-view-wrap personal-account">
    <div class="header-h3"><?= $arParams["USER"]["LAST_NAME"] ?> <?= $arParams["USER"]["NAME"] ?> <?= $arParams["USER"]["SECOND_NAME"] ?></div>
    <? if ($arResult["UPDATE"]) : ?>
        <p>Ваши данные обновлены</p>
    <? endif; ?>
    <form method="post" action="<?= $APPLICATION->GetCurPage() ?>" class="profile__form">
        <div class="view-item-employee">
            <label class="form-header">Личные данные</label>
            <div class="form-info-registration">
                <div class="form-row">
                    <label class="item-label">Фамилия</label>
                    <input type="text" name="USER[LAST_NAME]" placeholder="Фамилия" value="<?= $USER->GetLastName() ?>">
                </div>
                <div class="form-row">
                    <label class="item-label">Имя</label>
                    <input type="text" name="USER[NAME]" placeholder="Имя" value="<?=$USER->GetFirstName()?>">
                </div>
                <div class="form-row">
                    <label class="item-label">Отчество</label>
                    <input type="text" name="USER[SECOND_NAME]" placeholder="Отчество" value="<?=$USER->GetSecondName() ?>">
                </div>
                <div class="form-row">
                    <label class="item-label">Номер телефона</label>
                    <input type="text" class="input-phone-mask" name="USER[PERSONAL_PHONE]" placeholder="Номер телефона" value="<?=$arParams["USER"]["PERSONAL_PHONE"] ?>">
                </div>
                <div class="form-row">
                    <label class="item-label">Email</label>
                    <input disabled type="text" name="USER[EMAIL]" placeholder="Email" value="<?=$USER->GetEmail() ?>">
                </div>
                <div class="button-check-send">
                    <?= bitrix_sessid_post() ?>
                    <input disabled class="btn btn_register" type="submit" name="update-employee-info" value="Сохранить">
                </div>
            </div>
        </div>
    </form>
</div>