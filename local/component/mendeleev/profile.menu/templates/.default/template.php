<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>
<?php if ($arParams["MENU_LINKS"]): ?>
    <ul class="profile-aside-menu">
            <?php foreach ($arParams["MENU_LINKS"] as $arValue): ?>
                <li>
                    <a <?=($arValue["SELECTED"]? "class='active'" : "")?> href="<?=$arValue["URL"]?>"><?=$arValue["NAME"]?>
                        <? if (($arValue["SHOW_COUNT"] == true) && ($arValue["COUNT"] > 0)) :?>
                            <span class="bid-quantity"><?=$arValue["COUNT"]?><span>
                        <?else :?>
                            <i class="icon icon-user-blue"></i>
                        <?endif;?>
                    </a>
                </li>
            <?php endforeach; ?>
            <div class="profile-aside-logout">
                <a href="<?= $APPLICATION->GetCurPageParam("logout=yes&" . bitrix_sessid_get(), array(
                    "login",
                    "logout",
                    "register",
                    "forgot_password",
                    "change_password"
                )); ?>"><span class="icon icon-silngout"></span>Выход</a>
            </div>
    </ul>
    <select class="profile-aside-select-menu">
        <? foreach ($arParams["MENU_LINKS"] as $arValue): ?>
            <option <?=($arValue["SELECTED"]? "selected" : "")?> data-target="<?=$arValue["URL"]?>">
                <?=$arValue["NAME"]?>
                <? if (($arValue["SHOW_COUNT"] == true) && ($arValue["COUNT"] > 0)) :?>
                    <span class="bid-quantity"><?=$arValue["COUNT"]?><span>
                <?endif;?>
            </option>
        <?endforeach;?>
        <option data-target="<?= $APPLICATION->GetCurPageParam("logout=yes&" . bitrix_sessid_get(), array(
            "login",
            "logout",
            "register",
            "forgot_password",
            "change_password"
        )); ?>">Выход</option>
    </select>
<?php endif; ?>

