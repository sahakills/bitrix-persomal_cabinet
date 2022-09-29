$(function () {
    $(".content-button-archiv").on("click" , function (event) {
        event.preventDefault()
        let idElement = $(this).attr("data-id")
        BX.ajax.runComponentAction( 'mendeleev:profile.news', 'addToArchive', {
            mode: "ajax",
            data: {
                idNews: idElement,
            }
        }).then(function (response) {
           // $("#news-card-item-"+idElement).remove()
            location.reload()
        })
    })
})