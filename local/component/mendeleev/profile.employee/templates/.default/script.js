$(function () {
    $(".profile__form").on("change" , function () {
        $(this).find("input[type='submit']").prop("disabled" , false)
    })
})
