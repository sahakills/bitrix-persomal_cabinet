<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php
$APPLICATION->IncludeComponent(
    "mendeleev:profile.menu.inner.index",
    "",
    array(
        "AR_URL" => $arParams["URL_MENU"]
    )
);
?>
<div class="row profile-view-wrap employees">
    <div class="col-12">
        <? if ($arParams["ORGANIZATION"]["MODERATION"]) : ?>
            <div class="jqm-modal" id="modal-employees-add">
                <div class="close-modal"><svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M23.4375 6.5625L6.5625 23.4375" stroke="#3D454E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M23.4375 23.4375L6.5625 6.5625" stroke="#3D454E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>

                <div class="modal-container">
                    <div class="header-h3">Добавление сотрудника</div>
                    <form id="form-add_new_employee" method="post" action="<?= $APPLICATION->GetCurPage() ?>" data-custom-ajax="true" class="validate-form modal__form">
                        <div class="form-row">
                            <label class="item-label" for="firstName">Фамилия*</label>
                            <input data-error-target="firstName" type="text" name="USER[FIELD][NAME]" placeholder="Фамилия*" required>
                            <span class="error-input-message" id="firstName">Необходимо заполнить фамилию</span>
                        </div>
                        <div class="form-row">
                            <label class="item-label" for="lastName">Имя*</label>
                            <input data-error-target="lastName" type="text" name="USER[FIELD][LAST_NAME]" placeholder="Имя*" required>
                            <span class="error-input-message" id="lastName">Необходимо заполнить имя</span>
                        </div>
                        <div class="form-row">
                            <label class="item-label" for="secondName">Отчество*</label>
                            <input data-error-target="secondName" type="text" name="USER[FIELD][SECOND_NAME]" placeholder="Отчество*" required>
                            <span class="error-input-message" id="secondName">Необходимо заполнить отчество</span>
                        </div>
                        <div class="form-row">
                            <label class="item-label" for="phoneNumber">Номер телефона*</label>
                            <input data-error-target="phoneNumber" type="text" class="input-phone-mask" name="USER[FIELD][PERSONAL_PHONE]" placeholder="Номер телефона*" required>
                            <span class="error-input-message" id="phoneNumber">Необходимо заполнить номер телефона</span>
                        </div>
                        <div class="form-row">
                            <label class="item-label" for="email">Email*</label>
                            <input data-error-target="email" type="text" name="USER[FIELD][EMAIL]" placeholder="Email*" required>
                            <span class="error-input-message" id="email">Необходимо указать Email</span>
                        </div>
                        <div class="form-row">
                            <label class="item-label" for="status">Статус</label>
                            <input type="text" id="status" name="USER[PROPERTY][UF_USER_STATUS_STR]" placeholder="Статус">
                        </div>
                        <div class="form-row">
                            <div class="item-label">Доступные разделы</div>
                            <div class="services__direction-items select-wrapper providing">
                                <div class="direction-input-item fill-sections"><input type="text" placeholder="Новости и события" readonly></div>
                                <ul class="direction-list-item providing fill-sections">
                                    <div class="scroll-list-item">
                                        <? foreach ($arResult["LIST_DIRECTION"] as $arValue) : ?>
                                            <li class="list-item-text" data-value="<?= $arValue["ID"] ?>">
                                                <input type="checkbox" name="USER[PROPERTY][UF_EMPLOYEE_SECTION][]" value="<?= $arValue["ID"] ?>" id="cb-status-emp<?= $arValue["ID"] ?>">
                                                <label for="cb-status-emp<?= $arValue["ID"] ?>"><?= $arValue["VALUE"] ?></label>
                                            </li>
                                        <? endforeach; ?>
                                    </div>
                                </ul>
                            </div>
                        </div>
                        <div class="form-row">
                            <?= bitrix_sessid_post() ?>
                            <input type="hidden" name="ORGANIZATION" value="<?=$arParams["ORGANIZATION"]["ID"]?>">
                            <input type="hidden" name="add-new-employee" value="Добавить">
                            <input type="submit" class="btn btn_register"  value="Добавить">
                        </div>
                    </form>
                </div>
            </div>
            <div class="jqm-modal show-employees-modal modal-popup-edit" id="modal-employees-edit">
                <div class="close-modal"><svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M23.4375 6.5625L6.5625 23.4375" stroke="#3D454E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M23.4375 23.4375L6.5625 6.5625" stroke="#3D454E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div class="modal-container">
                    <div class="header-h3">Редактирование сотрудника</div>
                    <form id="modal-employees-edit-form" method="post" action="<?= $APPLICATION->GetCurPage() ?>" class="modal__form">
                        <div class="form-row">
                            <label class="item-label" for="employee-edit-name">Фамилия*</label>
                            <input type="text" name="USER[FIELD][NAME]" id="employee-edit-name" placeholder="Фамилия*" disabled>
                        </div>
                        <div class="form-row">
                            <label class="item-label" for="employee-edit-last_name">Имя*</label>
                            <input type="text" name="USER[FIELD][LAST_NAME]" id="employee-edit-last_name" placeholder="Имя*" disabled>
                        </div>
                        <div class="form-row">
                            <label class="item-label" for="employee-edit-second_name">Отчество*</label>
                            <input type="text" name="USER[FIELD][SECOND_NAME]" id="employee-edit-second_name" placeholder="Отчество*" disabled>
                        </div>
                        <div class="form-row">
                            <label class="item-label" for="employee-edit-personal_phone">Номер телефона*</label>
                            <input type="text" class="input-phone-mask" name="USER[FIELD][PERSONAL_PHONE]" id="employee-edit-personal_phone" placeholder="Номер телефона*" disabled>
                        </div>
                        <div class="form-row">
                            <label class="item-label" for="employee-edit-email">Email*</label>
                            <input type="text" name="USER[FIELD][EMAIL]" id="employee-edit-email" placeholder="Email*" disabled>
                        </div>
                        <div class="form-row">
                            <label class="item-label" for="employee-edit-status_str">Статус</label>
                            <input type="text" name="USER[PROPERTY][UF_USER_STATUS_STR]" id="employee-edit-status_str" placeholder="Статус">
                        </div>
                        <div class="form-row">
                            <div class="item-label">Доступные разделы</div>
                            <div class="services__direction-items select-wrapper providing">
                                <div class="direction-input-item edit-section-input"><input type="text" placeholder="Новости и события" readonly></div>
                                <ul class="direction-list-item providing fill-sections">
                                    <div class="scroll-list-item" id="employee-edit-list_section">

                                    </div>
                                </ul>
                            </div>
                        </div>
                        <div class="button-check-send profile-modal-button">
                            <input type="hidden" name="USER[ID]" id="employee-edit-id">
                            <?= bitrix_sessid_post() ?>
                            <input type="submit" class="btn btn_register" name="employee-edit" value="Редактировать сотрудника">
                        </div>
                    </form>
                </div>
            </div>

            <? if ($arResult["SUCCESS_ADD_EMPLOYEE"]) : ?>
                <div class="jqm-modal jqm-modal-notice" id="modal-employees-add-result">
                    <div class="close-modal"><svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23.4375 6.5625L6.5625 23.4375" stroke="#3D454E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M23.4375 23.4375L6.5625 6.5625" stroke="#3D454E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <div class="modal-wrap-jqm">
                        <div class="modal-container">
                            <? if ($arResult["SUCCESS_ADD_EMPLOYEE"] === true) : ?>
                                <div class="item-label">Сотрудник добавлен. Логин и пароль сотрудника будут отправлены на указанный Email.</div>
                            <? elseif (is_array($arResult["SUCCESS_ADD_EMPLOYEE"])) : ?>
                                <? foreach ($arResult["SUCCESS_ADD_EMPLOYEE"] as $sError) : ?>
                                    <div class="item-label"><?= $sError ?></div>
                                <? endforeach; ?>
                            <? else : ?>
                                <div class="item-label"><?= $arResult["SUCCESS_ADD_EMPLOYEE"] ?></div>
                            <? endif; ?>
                            <div class="modal-container-footer">
                                <input type="button" value="Понятно" class="btn-add btn btn_register">
                            </div>
                        </div>
                    </div>
                </div>
            <? endif; ?>

            <div class="jqm-modal jqm-modal-notice show-employees-delete-modal" id="modal-employees-delete-confirm">
                <div class="close-modal"><svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M23.4375 6.5625L6.5625 23.4375" stroke="#3D454E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M23.4375 23.4375L6.5625 6.5625" stroke="#3D454E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div class="modal-wrap-jqm">
                    <div class="modal-container">
                        <div class="item-label">Вы точно хотите удалить сотрудника? Отменить данное действие будет невозможно.</div>
                        <div class="modal-container-footer">
                            <input type="submit" value="Удалить" class="btn-delete btn btn_register">
                        </div>
                    </div>
                </div>
            </div>

            <? //основной контент странице?>
            <div class="header-h3">Учетные данные пользователей</div>
            <div class="profile__form">
                <div class="item-label">В данном разделе вы можете предоставить доступ к личному кабинету своим коллегам, а так же удалить пользователей. После добавления пользователей, они получат доступ к входу в ваш личный кабинет на сайте.</div>
                <div class="button-employees-add">
                    <button class="btn btn_register" id="button-employees-add">Добавить сотрудника</button>
                </div>
                <div class="edit__employees">
                    <div class="employees-label"><div class="item-label">ФИО</div><div class="item-label">Статус</div></div>
                    <?
                    foreach ($arResult["LIST_EMPLOYEE"] as $arValue) :
                    ?>
                        <div class="employees-container" data-user-id="<?= $arValue["ID"] ?>">
                            <div class="employees-info">
                                <div class="employees-fio"><?= $arValue["NAME"] . ' ' . $arValue["LAST_NAME"] . ' ' . $arValue["SECOND_NAME"] ?></div>
                                <div class="employees-status"><?= $arValue["UF_USER_STATUS_STR"] ?>
                                    <div class="employees-burger menu-burger">
                                        <ul>
                                            <li class="btn-edit-employee jqModal" data-user="<?= $arValue["ID"] ?>">Редактировать</li>
                                            <li class="btn-delete-employee" data-user="<?= $arValue["ID"] ?>">Удалить</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="employees-hide-content">
                                <div class="employees-content-items">
                                    <div class="employees-content-item">
                                        <div class="content-item-phone-h">Телефон</div>
                                        <div class="content-item-phone-number"><?= $arValue["PERSONAL_PHONE"] ?></div>
                                    </div>
                                    <div class="employees-content-item">
                                        <div class="content-item-sections-h">Доступные разделы</div>
                                        <div class="content-item-sections-text">
                                            <?
                                            if ($arValue["UF_EMPLOYEE_SECTION"]) :
                                                foreach ($arValue["SECTION_VALUE"] as $key => $sValue) :
                                                    if ($key == count($arValue["SECTION_VALUE"]) - 1) {
                                                        echo $sValue;
                                                        continue;
                                                    }
                                                    echo $sValue . ", ";
                                                endforeach;
                                            endif;
                                            ?>
                                        </div>
                                    </div>
                                    <div class="employees-content-item">
                                        <button class="content-item-button btn-edit-employee" data-user="<?= $arValue["ID"] ?>">Редактировать</button>
                                        <button class="content-item-button btn-delete-employee" data-user="<?= $arValue["ID"] ?>">Удалить</button>
                                    </div>
                                </div>
                                <div class="employees-content-items">
                                    <div class="employees-content-item">
                                        <div class="content-item-email-h">Email</div>
                                        <div class="content-item-email-text"><?= $arValue["EMAIL"] ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?
                    endforeach;
                    ?>

                </div>
            </div>
        <? else : ?>
            <div class="header-h3">Организация на модерации</div>
        <? endif; ?>
    </div>
</div>
