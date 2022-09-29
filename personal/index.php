<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");
?><?
    $APPLICATION->IncludeComponent(
        "mendeleev:profile" ,
        "" ,
        array(
            "SEF_FOLDER" => "/personal/",
            "SEF_URL_TEMPLATES" => array(
                "default" => array(
                    "index" => "", //profile.user , profile.organization , profile.employee
                    "index_edit" => "edit/", //profile.user.edit , profile.organization.edit , profile.employee.edit
                ),
                "organization" => array(
                    "index" => array(
                        "URL" => "",
                        "MENU" => true,
                        "NAME" => "Профиль"
                    ), //profile.user , profile.organization , profile.employee

                    "organization_employee" => array(
                        "URL" => "organization-employee/",
                        "MENU" => false
                    ), //profile.organization.employee
                    "service" => array(
                        "URL" => "service/",
                        "MENU" => true,
                        "NAME" => "Направления и услуги"
                    ), //profile.service сотрудники и владец организации
                    "service_add" => array(
                        "URL" => "service-add/",
                        "MENU" => false
                    ), //profile.service.add сотрудники и владец организации
                    "service_edit" => array(
                        "URL" => "service-edit/#SECTION_ID#/#SERVICE_ID#/",
                        "MENU" => false
                    ), //profile.service.edit сотрудники и владец организации
                    "news" => array(
                        "URL" => "news/",
                        "MENU" => true,
                        "NAME" => "Новости и события"
                    ), //profile.news сотрудники и владец организации
                    "news_section" => array(
                        "URL" => "news/#SECTION_ID#/",
                        "MENU" => false
                    ), //profile.news сотрудники и владец организации
                    "news_archive" => array(
                        "URL" => "news/archive/",
                        "MENU" => false
                    ), //profile.news сотрудники и владец организации
                    "news_add" => array(
                        "URL" => "news/add/#SECTION_ID#/",
                        "MENU" => false
                    ), //profile.news.add сотрудники с выбранным разделом и владец организации
                    "news_edit" => array(
                        "URL" => "news/edit/#SECTION_ID#/#ELEMENT_ID#/",
                        "MENU" => false
                    ), //profile.news.edit сотрудники с выбранным разделом и владец организаци
                    "hobby" => array(
                        "URL" => "hobby/",
                        "MENU" => true,
                        "NAME" => "Хобби и обучение"
                    ), //profile.news сотрудники и владец организации
                    "hobby_section" => array(
                        "URL" => "hobby/#SECTION_ID#/",
                        "MENU" => false
                    ), //profile.news сотрудники и владец организации
                    "hobby_add" => array(
                        "URL" => "hobby/add/#SECTION_ID#/",
                        "MENU" => false
                    ), //profile.news.add сотрудники с выбранным разделом и владец организации
                    "hobby_edit" => array(
                        "URL" => "hobby/edit/#SECTION_ID#/#ELEMENT_ID#/",
                        "MENU" => false
                    ), //profile.news.edit сотрудники с выбранным разделом и владец организации
                    "request" => array(
                        "URL" => "request/",
                        "MENU" => true,
                        "NAME" => "Заявки",
                        "SHOW_COUNT" => true
                    ), //profile.request сотрудники и владец организации сотрудники с выбранным разделом и владец организации
                    "request_done" => array(
                        "URL" => "request/done/",
                        "MENU" => false
                    ), //profile.request фильтр по статсу заявки сотрудники с выбранным разделом и владец организации
                    "request_archive" => array(
                        "URL" => "request-archive/",
                        "MENU" => false
                    ), //profile.request фильтр по статсу заявки, сотрудники с выбранным разделом и владец организации
                    "index_edit" => array(
                        "URL" => "edit/",
                        "MENU" => true,
                        "NAME" => "Безопасность"
                    ), //profile.user.edit , profile.organization.edit , profile.employee.edit
//                    "organization_edit" => "organization_edit/", //profile.organization.edit
                ),
                "employee" => array(
                    "index" => array(
                        "URL" => "",
                        "MENU" => true,
                        "NAME" => "Профиль"
                    ), //profile.user , profile.organization , profile.employee

                    "organization-info" => array(
                        "URL" => "organization-info/",
                        "MENU" => true,
                        "NAME" => "Информация организации"
                    ), //profile.organization.employee
                    "service" => array(
                        "URL" => "service/",
                        "MENU" => true,
                        "USER_SECTION" => 19,
                        "NAME" => "Направления и услуги"
                    ), //profile.service сотрудники с выбранным разделом
                    "service_add" => array(
                        "URL" => "service/add/",
                        "MENU" => false
                    ), //profile.service.add сотрудники с выбранным разделом
                    "service_edit" => array(
                        "URL" => "service/edit/#SECTION_ID#/#SERVICE_ID#",
                        "MENU" => false
                    ), //profile.service.edit сотрудники с выбранным разделом
                    "news" => array(
                        "URL" => "news/",
                        "MENU" => true,
                        "USER_SECTION" => 16,
                        "NAME" => "Новости и события"
                    ), //profile.news сотрудники с выбранным разделом
                    "news_section" => array(
                        "URL" => "news/#SECTION_ID#/",
                        "MENU" => false
                    ), //profile.news сотрудники и владец организации
                    "news_add" => array(
                        "URL" => "news-add/#SECTION_ID#/",
                        "MENU" => false
                    ), //profile.news.add сотрудники с выбранным разделом
                    "news_edit" => array(
                        "URL" => "news-edit/#SECTION_ID#/#ELEMENT_ID#/",
                        "MENU" => false
                    ), //profile.news.edit сотрудники с выбранным разделом
                    "news_archive" => array(
                        "URL" => "news/archive/",
                        "MENU" => false
                    ), //profile.news сотрудники и владец организации
                    "hobby" => array(
                        "URL" => "hobby/",
                        "MENU" => true,
                        "USER_SECTION" => 17,
                        "NAME" => "Хобби и обучение"
                    ), //profile.news сотрудники и владец организации
                    "hobby_add" => array(
                        "URL" => "hobby/add/#SECTION_ID#/",
                        "MENU" => false
                    ), //profile.news.add сотрудники с выбранным разделом и владец организации
                    "hobby_edit" => array(
                        "URL" => "hobby/edit/#SECTION_ID#/#ELEMENT_ID#/",
                        "MENU" => false
                    ), //profile.news.edit сотрудники с выбранным разделом и владец организации
                    "hobby_section" => array(
                        "URL" => "hobby/#SECTION_ID#/",
                        "MENU" => false
                    ), //profile.news сотрудники и владец организации
                    "request" => array(
                        "URL" => "request/",
                        "MENU" => true,
                        "USER_SECTION" => 18,
                        "NAME" => "Заявки",
                        "SHOW_COUNT" => true
                    ), //profile.request сотрудники с выбранным разделом
                    "request_done" => array(
                        "URL" => "request/done/",
                        "USER_SECTION" => 18,
                        "MENU" => false
                    ), //profile.request фильтр по статсу заявки сотрудники с выбранным разделом
                    "request_archive" => array(
                        "URL" => "request/archive/",
                        "USER_SECTION" => 18,
                        "MENU" => false
                    ), //profile.request фильтр по статсу заявки, сотрудники с выбранным разделом
                    "index_edit" => array(
                        "URL" => "edit/",
                        "MENU" => true,
                        "NAME" => "Безопасность"
                    ), //profile.user.edit , profile.organization.edit , profile.employee.edit
                )
            ),

            "USER_FIELD_TYPE" => "UF_TYPE",
            "USER_TYPE" => array(
                null => 'default',
                1 => 'organization',
                2 => 'employee'
            ),
            "PAGE_LOGIN" => "/login/",
            "USER_TYPE_ORGANIZATION" => 1,
            "IBLOCK_ORGANIZATION" => 24,
            "IBLOCK_NEWS" => 16,
            "IBLOCK_HOBBY" => 19,
            "IBLOCK_REQUEST" => 32,
            "IBLOCK_SERVICE" => 30,
            "IBLOCK_SPEAKER" => 25,
            //список пользовательского свойства
            "RIGHT_SERVICE" => 19,
            "RIGHT_NEWS" => 16,
            "RIGHT_HOBBY" => 17	,
            "RIGHT_REQUEST" => 18,
//            "AJAX_MODE" => "Y"
        )
    )
?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>