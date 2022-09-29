<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
    die();
}
?>
<div class="container container-form register_form">
    <div class="row">
    <div class="col-lg-6 col-md-12">
        <div id="bx_register_resend"></div>
        <form method="post" action="<?=POST_FORM_ACTION_URI?>" name="regform" class="container-form-wrap">

            <div class="container-form-header">
                <a href="/">
                    <img src="<?=SITE_TEMPLATE_PATH?>/assets/images/Registration/Frame.png" alt="">
                </a>
                <p>
                    Единый информационно-просветительский портал для людей с инвалидностью
                </p>
            </div>
            <div class="container-form-title">
                <span>Подтверждение смены почты</span>
            </div>
            <? if ($arResult["UPDATE"]): ?>
                <p>Ваша почта и логин изменены</p>
            <?elseif(!$arResult["UPDATE"]): ?>
                <p><?=$arResult["ERROR"]?></p>
                <div class="container-form-body">
                    <div class="form-row">
                        <input type="text" name="CHECKWORD" value="<?=$_GET["CHECKWORD"]?>" placeholder="Секретный ключ *" required>
                    </div>
                    <div class="form-row">
                        <?=bitrix_sessid_post()?>
                        <input type="submit" name="update_email" class="btn-flex btn_register" value="Подтверждение смены почты" />
                    </div>
                </div>
            <?endif;?>
        </form>
    </div>
    <div class="col-lg-6 d-none d-lg-flex">
        <div class="wrap-img">
            <img src="<?=SITE_TEMPLATE_PATH?>/assets/images/Registration/Group%20707.png" alt="">
        </div>
    </div>
</div>
</div>