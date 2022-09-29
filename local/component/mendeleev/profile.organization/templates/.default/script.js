$(function () {
    //запрещаем отправлять новю инфу об организации пока не изменем данные в форме
    intPageOrganization();
})
$(document).on("submit","#form-edit-organization" , function () {
    BX.addCustomEvent('onAjaxSuccess', initAfterAjax);
})
function intPageOrganization () {
    let btnToMobalProfilOrganization = $(".profile__form").find("input[type=submit]");
    $(".profile__form").on("change, input", function (event) {
        if (btnToMobalProfilOrganization.attr('disabled') !== undefined) {
            btnToMobalProfilOrganization.prop("disabled", false);
        }
    });
    BX.removeCustomEvent('onAjaxSuccess', initAfterAjax);
}

function initAfterAjax() {
    let forms = $('.validate-form');
    forms.each(function (index, htmlForm) {
        collectionsForms[index] = new formValid(htmlForm);
    })
    $('.jqm-modal').jqmHide()

    intPageOrganization();

    createNewElementSelect(".select")

    initAjaxInput();

    initCheckboxInput();

    initEventCheckbox();

    tinyMCEAfterAjax();

    $("#modal-organization-result").jqm({
        onHide: function () {
            updatePage();
        }
    })
    $("#modal-organization-result").jqmShow();
}
