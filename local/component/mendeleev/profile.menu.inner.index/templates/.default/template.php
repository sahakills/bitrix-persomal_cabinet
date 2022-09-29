<div class="tabs">
    <ul class="tabs-nav tabs-nav-horizontal">
        <? foreach ($arResult["LIST_SECTION"] as $arSection) :
            if ($arSection["ACTIVE"] === "N"):?>
                <li><span class="tabs-el-deactivate"><?= $arSection["NAME"] ?></span></li>
            <? else: ?>
            <li><a href="<?= $arSection["URL"] ?>" <?= ($arSection["SELECT"]) ? "class='active'" : "" ?>><?= $arSection["NAME"] ?></a></li>
        <? endif;
        endforeach; ?>
    </ul>
</div>