$(function() {
    $(".add_to_done").on("click" , function (event) {
        // event.preventDefault()
        let id = $(this).attr("data-id")
        BX.ajax.runComponentAction( "mendeleev:profile.request.list", "addToDone", {
            mode: 'ajax',
            data: {
                id: id
            }
        }).then(function (response) {
            console.log(response)
            window.location.reload()
        })
    })
    let IdElement = "";
    $(".archiv-button").on("click" , function (event) {
        // event.preventDefault()
        IdElement = $(this).find(".add_to_archive").attr("data-id")
    })
    $(".form_send_item_to_archive").on("submit" , function (event) {
        event.preventDefault()
        let text = $("input[name='textArchive']").val()
        BX.ajax.runComponentAction( "mendeleev:profile.request.list", "addToArchive", {
            mode: 'ajax',
            data: {
                id: IdElement,
                strText: text
            }
        }).then(function (response) {
            window.location.reload()
        })
    })
})