$(function () {
    $(".jqm-modal").jqm()
    $(".close-modal").on("click" , function () {
        $(".jqm-modal").jqmHide()
    })
    let modalCurrent;
    $(".open-modal-accept-del").on("click" , function (event) {
        event.preventDefault()
        let popupId = $(this).attr("data-modal")
        modalCurrent = $('.'+popupId).jqmShow()
    })
    $(".content-button-delete").on("click" , function (event) {
        event.preventDefault()
        let idElement = $(this).attr("data-id")
        BX.ajax.runComponentAction( 'mendeleev:profile.news', 'deleteFromArchive', {
            mode: "ajax",
            data: {
                idNews: idElement,
            }
        }).then(function (response) {
            if (response.data == true) {
                window.location.reload();
            } else {
                $(modalCurrent).find(".modal-content").html("Ошибка при удалении")
            }
        })
    })
})