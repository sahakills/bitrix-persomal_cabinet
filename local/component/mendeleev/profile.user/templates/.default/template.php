<?
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

//mpr($arResult  , false);

?>

<div class="col-lg-8 profile-view">
    <div class="row profile-view-wrap">
        <div class="col-md-12 profile-view-wrap-row profile-img">
            <div class="profile-img-wrap">
                <?
                if (!empty($arResult['arUser']['PERSONAL_PHOTO'])) {
                    ?>
                    <div class="profile-img-wrap-true">
                        <img class="" src="<?=CFile::GetPath($arResult['arUser']['PERSONAL_PHOTO'])?>" alt="">
                        <a class="profile-img-wrap-true-edit" href="<?=$APPLICATION->GetCurPageParam('edit=true')?>"> <i class="icon change-img"></i></a>
                    </div>
                    <?
                } else {
                    ?>
                    <div class="profile-img-wrap-none">
                        <img class="" src="/upload/medialibrary/f98/5b3jmlpjmv1jo28a824od1yr3bqu0i6f.png" alt="">
                        <a class="profile-img-wrap-link-photo" href="<?=$APPLICATION->GetCurPageParam('edit=true')?>" >Добавить фото</a>
                    </div>

                    <?
                }
                ?>
            </div>
            <div class="profile-img-name">
                <?=$USER->GetFullName()?>
            </div>
        </div>
        <div class="col-md-4 profile-view-wrap-row profile-info">
            <span class="profile-view-wrap-row-label">Дата рождения</span>
            <span class="profile-view-wrap-row-value"><?=(is_null($arResult['arUser']['PERSONAL_BIRTHDAY'])) ? 'Не указано' : $arResult['arUser']['PERSONAL_BIRTHDAY']?></span>
        </div>
        <div class="col-md-8 profile-view-wrap-row-fluid profile-info">
            <span class="profile-view-wrap-row-label">Пол</span>
            <span class="profile-view-wrap-row-value"><?=($arResult['arUser']['PERSONAL_GENDER'] == 'M') ? 'Мужской' : ''?><?=($arResult['arUser']['PERSONAL_GENDER'] == 'F') ? 'Женский' : ''?></span>
        </div>
        <div class="col-md-4 profile-view-wrap-row profile-info">
            <span class="profile-view-wrap-row-label">Город</span>
            <span class="profile-view-wrap-row-value">Тюмень</span>
        </div>
        <div class="col-md-8 profile-view-wrap-row-fluid profile-info">
            <span class="profile-view-wrap-row-label">Район проживания</span>
            <span class="profile-view-wrap-row-value">Центральный</span>
        </div>
        <div class="col-md-4 profile-view-wrap-row profile-info">
            <span class="profile-view-wrap-row-label">Группа</span>
            <span class="profile-view-wrap-row-value"><?=(is_null($arResult['arUser']['UF_GROUP_DISABILITY'])) ? 'Не указано' : $arResult['arUser']['UF_GROUP_DISABILITY']?></span>
        </div>
        <div class="col-md-8 profile-view-wrap-row-fluid profile-info">
            <span class="profile-view-wrap-row-label">Категория доступности</span>
            <span class="profile-view-wrap-row-value"><?=(is_null($arResult['arUser']['UF_PROPACCESS'])) ? 'Не указано' : $arResult['arUser']['UF_PROPACCESS']?></span>
        </div>
        <div class="col-md-12 profile-view-wrap-row profile-input-link">
            <a href="<?=$APPLICATION->GetCurPageParam('edit=true')?>">Редактировать профиль</a>
        </div>
    </div>
    <div class="row profile-view-wrap">
        <div class="col-md-12 profile-view-wrap-row profile-input">
            <div class="profile-input-label">
                <span class="profile-view-wrap-row-label">Телефон</span>
                <span class="profile-view-wrap-row-value"><?=(empty($arResult['arUser']['PERSONAL_PHONE'])) ? 'Не указано' : $arResult['arUser']['PERSONAL_PHONE']?></span>
            </div>
            <div class="profile-input-link">
                <a href="">Изменить</a>
            </div>
        </div>
        <div class="col-md-12 profile-view-wrap-row profile-input">
            <div class="profile-input-label">
                <span class="profile-view-wrap-row-label">Электронная почта</span>
                <span class="profile-view-wrap-row-value"><?=$arResult['arUser']['EMAIL']?></span>
            </div>
            <div class="profile-input-link">
                <a href="<?=$APPLICATION->GetCurPageParam('edit=true')?>">Изменить</a>
            </div>
        </div>
        <div class="col-md-12 profile-view-wrap-row profile-input">
            <div class="profile-input-label">
                <span class="profile-view-wrap-row-label">Пароль</span>
                <span class="profile-view-wrap-row-value">****</span>
            </div>
            <div class="profile-input-link">
                <a href="<?=$APPLICATION->GetCurPageParam('edit=true')?>">Изменить</a>
            </div>
        </div>
    </div>
</div>

