<div class="tabs">
    <ul class="tabs-nav-horizontal">
        <?
        foreach ($arResult["LIST_SECTION"] as $intKey => $arSection) :
            ?>
            <li><a href="<?=$arSection["LINK_SECTION"]?>" <?=($arSection["ID"] == $arParams["CURRENT_SECTION"])? 'class="active"' : ""?>><?=$arSection["NAME"]?></a></li>
        <?
        endforeach;
        ?>
        <?
        if ($arParams["ARCHIVE"] != "N") :
            ?>
            <li><a href="<?=$arParams["URL_MENU_ARCHIVE"]?>">Архив</a></li>
        <?
        endif;
        ?>
    </ul>
</div>
