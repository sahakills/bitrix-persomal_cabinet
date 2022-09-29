$(function() {
   $(".profile-aside-select-menu").on("change" , function () {
        let optionSelected = $("option:selected", this).attr("data-target");
        if (optionSelected.length > 0) {
            location.href = optionSelected;
        }
   })
})