<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php
//$titles = array('Сидит %d котик', 'Сидят %d котика', 'Сидит %d котиков');
$arMessage = array("%d услуга" , "%d услуги" , "%d услуг");

?>
<div class="col-lg-8 profile-view">
    <div class="row profile-view-wrap services">
        <div class="services-box">
            <? if (empty($arResult["ERROR"])) : ?>
                <div class="header-h3">Направления и услуги</div>
                <div class="button-section-add">
                    <a class="btn btn_register" href="<?=$arParams["URL"]["URL_TEMPLATES_SERVICE_ADD"]?>">Добавить услугу</a>
                </div>
                <form method="post" action="/" class="services__form">
                    <div class="edit__services">
                        <div class="services-label"><label class="item-label">Направление</label><label class="item-label">Количество услуг</label></div>
                        <div class="services-container">
                            <?
                                if ($arResult["ORGANIZATION"]['SERVICE_LIST']) :
                                    foreach ($arResult["ORGANIZATION"]['SERVICE_LIST'] as $intKey => $arSection):
                                    ?>
                                    <div class="services-box-item">
                                        <div class="services-info">
                                            <div class="services-section"><?=$intKey?></div>
                                            <div class="services-count"><?=declOfNum(count($arSection), $arMessage)?>
                                                <div class="services-burger">
                                                    <ul>
                                                        <li>Скрыть направление</li>
                                                        <li>Удалить</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="services-hide-content">
                                            <div class="services-content-items">
                                                <div class="content-items-header">Услуги</div>
                                                <div class="services-content-item">
                                                    <?
                                                        foreach ($arSection as $arItem) :
                                                        ?>
                                                        <div class="content-item-text"><?=$arItem['NAME']?><span class="service-icon"><a href="<?=$arItem["LINK_EDIT"]?>"></a></span></div>
                                                        <?
                                                        endforeach;
                                                    ?>
                                                </div>
                                                <div class="services-content-item-button">
                                                    <a href="<?=$arParams["URL"]["URL_TEMPLATES_SERVICE_ADD"]?>">Добавить услугу</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?
                                    endforeach;
                                endif;
                            ?>
                        </div>
                    </div>
                </form>
            <? else: ?>
                <div class="header-h3"><?=$arResult["ERROR"]["MESSAGE"]?></div>
            <?endif;?>
        </div>
    </div>
</div>