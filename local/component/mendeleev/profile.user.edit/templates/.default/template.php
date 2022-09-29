<?
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();


?>
<div class="container profile">
    <div class="row">
        <aside class="col-lg-4 profile-aside">
            <ul class="profile-aside-menu">
                <li>
                    <a href="/personal/" class="active"><i class="icon icon-user-blue"></i>Профиль</a>
                </li>
                <?/**
                <li>
                    <a href=""><i class="icon icon-notice"></i>Уведомления</a>
                </li>
                <li>
                    <a href=""><i class="icon icon-history"></i> История поиска</a>
                </li>
                <li>
                    <a href=""><i class="icon icon-gear"></i> Безопасность</a>
                </li>
                 * **/?>
            </ul>
            <div class="profile-aside-logout">
                <a href="<?=$APPLICATION->GetCurPageParam("logout=yes&".bitrix_sessid_get(), array(
                    "login",
                    "logout",
                    "register",
                    "forgot_password",
                    "change_password"));?>"><span class="icon icon-silngout"></span>Выход</a>
            </div>
        </aside>

        <?ShowError($arResult["strProfileError"]);?>
        <?
        if ($arResult['DATA_SAVED'] == 'Y')
            ShowNote(GetMessage('PROFILE_DATA_SAVED'));
        ?>
        <script type="text/javascript">
            <!--
            var opened_sections = [<?
                $arResult["opened"] = $_COOKIE[$arResult["COOKIE_PREFIX"]."_user_profile_open"];
                $arResult["opened"] = preg_replace("/[^a-z0-9_,]/i", "", $arResult["opened"]);
                if ($arResult["opened"] <> '')
                {
                    echo "'".implode("', '", explode(",", $arResult["opened"]))."'";
                }
                else
                {
                    $arResult["opened"] = "reg";
                    echo "'reg'";
                }
                ?>];
            //-->

            var cookie_prefix = '<?=$arResult["COOKIE_PREFIX"]?>';
        </script>
        <form class="col-lg-8 profile-view  profile-edit" method="post" name="form-edit-profile" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
            <?=$arResult["BX_SESSION_CHECK"]?>
            <input type="hidden" name="lang" value="<?=LANG?>" />
            <input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
            <div class="row profile-view-wrap">
                <div class="col-md-12 profile-view-wrap-row profile-img">
                    <div class="profile-img-wrap">
                        <?
                        if (!empty($arResult['arUser']['PERSONAL_PHOTO'])) {
                            ?>
                            <div class="profile-img-wrap-true">
                                <img class="" src="<?=CFile::GetPath($arResult['arUser']['PERSONAL_PHOTO'])?>" alt="">
                                <input type="file" name="PERSONAL_PHOTO" id="change_photo-profile">
                                <label class="profile-img-wrap-true-edit" for="change_photo-profile"> <i class="icon change-img"></i></label>
                            </div>
                            <?
                        } else {
                            ?>
                            <div class="profile-img-wrap-none">
                                <img class="" src="/upload/medialibrary/f98/5b3jmlpjmv1jo28a824od1yr3bqu0i6f.png" alt="">
                                <input name="PERSONAL_PHOTO" type="file" id="edit_photo-profile">
                                <label class="profile-img-wrap-link-photo" for="edit_photo-profile">Добавить фото</label>
                            </div>

                            <?
                        }
                        ?>
                    </div>
                    <div class="profile-img-name">
                        <?=$USER->GetFullName()?>
                    </div>
                </div>
                <div class="col-md-12 profile-view-wrap-row">
                    <span class="profile-view-wrap-row-label">Дата рождения</span>
                    <?
                    $APPLICATION->IncludeComponent(
                        'bitrix:main.calendar',
                        '',
                        array(
                            'SHOW_INPUT' => 'Y',
                            'FORM_NAME' => 'form1',
                            'INPUT_NAME' => 'PERSONAL_BIRTHDAY',
                            'INPUT_VALUE' => $arResult["arUser"]["PERSONAL_BIRTHDAY"],
                            'SHOW_TIME' => 'N'
                        ),
                        null,
                        array('HIDE_ICONS' => 'Y')
                    );
                    ?>
                </div>
                <div class="col-md-12 profile-view-wrap-row" >
                    <span class="profile-view-wrap-row-label">Пол</span>
                    <select name="PERSONAL_GENDER">
                        <option value=""><?=GetMessage("USER_DONT_KNOW")?></option>
                        <option value="M"<?=$arResult["arUser"]["PERSONAL_GENDER"] == "M" ? " SELECTED=\"SELECTED\"" : ""?>>Мужской</option>
                        <option value="F"<?=$arResult["arUser"]["PERSONAL_GENDER"] == "F" ? " SELECTED=\"SELECTED\"" : ""?>>Женский</option>
                    </select>
                </div>
                <div class="col-md-12 profile-view-wrap-row" >
                    <span class="profile-view-wrap-row-label"><?=$arResult['USER_PROPERTIES']['DATA']['UF_PROPACCESS']['EDIT_FORM_LABEL']?></span>
                    <?

                    $APPLICATION->IncludeComponent(
                        "bitrix:system.field.edit",
                        $arResult['USER_PROPERTIES']['DATA']['UF_PROPACCESS']["USER_TYPE"]["USER_TYPE_ID"],
                        array(
                            "bVarsFromForm" => $arResult["bVarsFromForm"],
                            "arUserField" => $arResult['USER_PROPERTIES']['DATA']['UF_PROPACCESS']),
                        null,
                        array("HIDE_ICONS"=>"Y"));
                    ?>
                </div>
                <div class="col-md-12 profile-view-wrap-row" >
                    <span class="profile-view-wrap-row-label"><?=$arResult['USER_PROPERTIES']['DATA']['UF_GROUP_DISABILITY']['EDIT_FORM_LABEL']?></span>
                    <?

                    $APPLICATION->IncludeComponent(
                        "bitrix:system.field.edit",
                        $arResult['USER_PROPERTIES']['DATA']['UF_GROUP_DISABILITY']["USER_TYPE"]["USER_TYPE_ID"],
                        array(
                            "bVarsFromForm" => $arResult["bVarsFromForm"],
                            "arUserField" => $arResult['USER_PROPERTIES']['DATA']['UF_GROUP_DISABILITY']),
                        null,
                        array("HIDE_ICONS"=>"Y"));
                    ?>
                </div>
                <div class="col-md-12 profile-view-wrap-row">
                    <span class="profile-view-wrap-row-label">Телефон:</span>
                    <input type="text" name="PERSONAL_PHONE" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>" />
                </div>

                <div class="col-md-12 profile-view-wrap-row" >
                    <span class="profile-view-wrap-row-label">E-Mail: <?if($arResult["EMAIL_REQUIRED"]):?><span class="starrequired">*</span><?endif?></span>
                    <input type="text" name="EMAIL" maxlength="50" value="<? echo $arResult["arUser"]["EMAIL"]?>" />
                </div>

                <?if($arResult['CAN_EDIT_PASSWORD']) {?>
                    <div class="col-md-12 profile-view-wrap-row" >
                        <span class="profile-view-wrap-row-label">Новый пароль:</span>
                        <input type="password" name="NEW_PASSWORD" maxlength="50" autocomplete="off"/>
                        <?if($arResult["SECURE_AUTH"]):?>
                            <span class="bx-auth-secure" id="bx_auth_secure" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
                                <div class="bx-auth-secure-icon"></div>
                            </span>
                            <noscript>
                                <span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
                                    <div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
                                </span>
                            </noscript>
                            <script type="text/javascript">
                                document.getElementById('bx_auth_secure').style.display = 'inline-block';
                            </script>
                        <?endif?>

                    </div>
                    <div class="col-md-12 profile-view-wrap-row" >
                        <span class="profile-view-wrap-row-label">Подтверждение нового пароля:</span>
                        <input type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" autocomplete="off" />
                    </div>
                    <div class="col-md-12 profile-view-wrap-row" >
                        <?=$arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?>
                    </div>
                    <div class="col-md-12 profile-view-wrap-row" >
                        <input type="submit" name="save" value="<?=(($arResult["ID"]>0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD"))?>">
                        <input type="reset" value="<?=GetMessage('MAIN_RESET');?>">
                    </div>
                <?}?>
                <? /**= $arResult["arUser"]["PERSONAL_PHOTO_INPUT"]?>
                <?
                if ($arResult["arUser"]["PERSONAL_PHOTO"] <> '')
                {
                    ?>
                    <br />
                    <?=$arResult["arUser"]["PERSONAL_PHOTO_HTML"]?>
                    <?
                }**/
                ?>
            </div>
        </form>
    </div>
</div>