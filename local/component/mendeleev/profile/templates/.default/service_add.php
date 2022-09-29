 <?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
 <div class="container profile">
     <div class="row">
         <div class="col-12">
             <div class="header-h2">Личный кабинет</div>
         </div>
     </div>
     <div class="row">
         <aside class="col-lg-4 profile-aside">
             <?
             $APPLICATION->IncludeComponent(
                 "mendeleev:profile.menu",
                 "",
                 array(
                     "MENU_LINKS" => $arResult["MENU_LINKS"],
                     "ORGANIZATION" => $arResult["ORGANIZATION"],
                     "IBLOCK_REQUEST" => 32,
                 )
             )
             ?>
         </aside>
         <div class="col-lg-8 profile-view">
         <?
            $APPLICATION->IncludeComponent(
                "mendeleev:profile.service.add",
                "",
                array(
                    "ORGANIZATION" => $arResult["ORGANIZATION"],
                    "USER" => $arResult["USER"],
                    "URL" => $arResult["PATH_TEMPLATE"],
                    "RIGHT_SERVICE" => $arParams["RIGHT_SERVICE"],
                    "AJAX_MODE" => "Y",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                )
            );
            ?>
         </div>
     </div>
 </div>