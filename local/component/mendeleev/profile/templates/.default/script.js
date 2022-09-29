$(function () {
    if ($(window).width()) {

        createNewElementSelect(".select");

        initAjaxInput()

        initCheckboxInput()

        initEventCheckbox()
    }


    /* Событие после заполнения input в модальных окнах раздела сотрудники  */
    $(".modal__form input").on("blur", function (e) {
        $(this).addClass("visited");
    });


    /* Событие при нажатии на кнопку+ Добавить новость, хобби, направление */
    $(".services-button-add").on("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        let cloneNews = $(".form__clone-container").clone();
        $(".append-form__container").append(cloneNews);
    });

    $(".link-create-show").on("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        $this = $(this);
        $currentCreateItem = $this.closest(".list-item-create");
        $currentAddItem = $this.closest(".new-select__list").find(".list-item-add");
        if ($currentCreateItem.hasClass("active")) {
            $currentCreateItem.removeClass("active");
        } else {
            $currentCreateItem.addClass("active");
            $currentAddItem.show();
        }
    });

    /* События работы с модальными окнами */

    $(".show-archiv-modal").jqm({ trigger: ".archiv-button" });
    $(document).on("click", ".close-modal", function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(".show-organization-success-modal").jqmHide();
        $(".modal-popup").jqmHide();
        $(".modal-popup-edit").jqmHide();
        $(".show-employees-success-modal").jqmHide();
        $(".show-employees-delete-modal").jqmHide();
        $(".show-archiv-modal").jqmHide();
    });

    //закрытие модальных окон
    $(document).on("click" , ".close-jqm-modal" , function () {
        $(".jqm-modal").jqmHide()
    })
    $(".button-check-send.modal--button").on("click", function (e) {
        $(".modal-popup").jqmHide();
    });



    /* Отчистка форма */
    // $(".services-button-cancel").on("click", (e) => {
    //     updatePage();
    // });

    /* Добавление файла в разделе Профиль */
    let fileZone = $(".insert-file");
    let fileObject = {
        filereader: typeof FileReader != "undefined",
        dnd: "draggable" in document.createElement("span"),
        formdata: !!window.FormData,
        progress: "upload" in new XMLHttpRequest
    }

    let acceptedTypesFile = {
        "image/png": true,
        "image/jpeg": true,
        "image/gif": true,
        "application/pdf": true

    }

    fileZone.on("drag dragstart dragend dragover dragenter dragleave drop", function () {
        return false;
    });

    fileZone.on("dragover dragenter", function () {
        dropZone.addClass("dragover");
    });

    fileZone.on("dragleave", function (e) {
        let dx = e.pageX - dropZone.offset().left;
        let dy = e.pageY - dropZone.offset().top;
        if ((dx < 0) || (dx > dropZone.width()) || (dy < 0) || (dy > dropZone.height())) {
            dropZone.removeClass("dragover");
        }
    });

    fileZone.on("drop", function (e) {
        dropZone.removeClass("dragover");
        let files = e.originalEvent.dataTransfer.files;
        sendFileInn(files);
    });

    $("#file-input-org").change(function () {
        let files = this.files;

        sendFileInn(files);
    });

    /* Добавление фотографии в разделе Новости и Хобби */

    let dropZone = $(".photo-element");
    let tests = {
        filereader: typeof FileReader != "undefined",
        dnd: "draggable" in document.createElement("span"),
        formdata: !!window.FormData,
        progress: "upload" in new XMLHttpRequest
    }
    let acceptedTypes = {
        "image/png": true,
        "image/jpeg": true,
        "image/gif": true,
        "application/pdf": true
    }
    let holder = $(".output-photo-file");
    let fileHoder = $(".output-file");

    dropZone.on("drag dragstart dragend dragover dragenter dragleave drop", function () {
        return false;
    });

    dropZone.on("dragover dragenter", function () {
        dropZone.addClass("dragover");
    });

    dropZone.on("dragleave", function (e) {
        let dx = e.pageX - dropZone.offset().left;
        let dy = e.pageY - dropZone.offset().top;
        if ((dx < 0) || (dx > dropZone.width()) || (dy < 0) || (dy > dropZone.height())) {
            dropZone.removeClass("dragover");
        }
    });

    dropZone.on("drop", function (e) {
        dropZone.removeClass("dragover");
        let files = e.originalEvent.dataTransfer.files;
        sendFiles(files);
    });

    $("#file-input").change(function () {
        let files = this.files;
        sendFiles(files);
    });

    function previewfile(file) {
        if (tests.filereader === true && acceptedTypes[file.type] === true) {
            var reader = new FileReader();
            reader.onload = function (event) {
                holder.empty()
                holder.append(
                    BX.create(
                        "img", {
                        attrs: {
                            src : event.target.result,
                            width: 250,
                            alt: file.name
                        }}
                    ),
                    BX.create(
                        "span",{
                            attrs: {
                                className: "output-photo-file-name",
                            },
                            text: file.name
                        }
                    ),
                    BX.create(
                        "div", {
                            attrs: {
                                className: "output-photo-file-icon-del"
                            },
                            children: [
                                BX.create(
                                    "i", {
                                        attrs: {
                                            className: "icon icon-trash"
                                        }
                                    }
                                )
                            ]
                        }
                    )

                )
            };
            reader.readAsDataURL(file);
        } else {
            holder.innerHTML += "<p>Uploaded " + file.name + " " + (file.size ? (file.size / 1024 | 0) + "K" : "");
        }
    }

    function previewfileDocument(file) {
        if (tests.filereader === true && acceptedTypes[file.type] === true) {
            var reader = new FileReader();
            reader.readAsDataURL(file);
            if (file.type === "application/pdf" || file.type === "image/jpeg" || file.type === "image/png") {
                fileHoder.empty();
                fileHoder.append($("<p>", {
                    class: "file-output-inner",
                    text: "документ: " + file.name
                }));
            }
        } else {
            holder.innerHTML += "<p>Uploaded " + file.name + " " + (file.size ? (file.size / 1024 | 0) + "K" : "");
        }
    }

    function sendFiles(files) {
        var formData = new FormData();
        for (var i = 0; i < files.length; i++) {
            if (tests.formdata) formData.append("file", files[i]);
            previewfile(files[i]);
        }
    }

    function sendFileInn(files) {
        // var formData = tests.formdata ? new FormData() : null;
        var formData = new FormData();
        for (var i = 0; i < files.length; i++) {
            if (tests.formdata) formData.append("file", files[i]);
            previewfileDocument(files[i]);
        }
        if (tests.formdata) {
            $.ajax({

            });
        }
    }

    $(document).on("click", ".output-photo-file-icon-del .icon-trash" , function () {
        deletePhotoPost(this)
    })
    /* jquery Input Mask */
    $(".input-phone-mask").inputmask({"mask": "+7 (999) 999-9999"});
    $("#info_inn").inputmask({ "mask": "9999 999999", "greedy": false});

});

/* Функция создания новых элементов в custom select после ajax*/
function createNewElementSelect(nameElement) {
    $(nameElement).each(function () {
        const _this = $(this),
            selectOption = _this.find("option:not([disabled])"),
            selectOptionLength = selectOption.length,
            selectedOption = selectOption.filter(":selected"),
            duration = 450; // длительность анимации
        _this.hide();
        _this.wrap('<div class="select"></div>');
        $("<div>", {
            class: "new-select",
            text: _this.children("option:selected").text()
        }).insertAfter(_this);

        const selectHead = _this.next(".new-select");
        $("<div>", {
            class: "new-select__list"
        }).insertAfter(selectHead);
        const selectList = selectHead.next(".new-select__list");
        for (let i = 0; i < selectOptionLength; i++) {
            $("<div>", {
                class: "new-select__item",
                html: $("<span>", {
                    text: selectOption.eq(i).text()
                })
            })
                .attr("data-value", selectOption.eq(i).val())
                .appendTo(selectList);
        }

        const createSelectList = selectHead.next(".new-select__list");

        if (_this[0].name === "directionSelect") {

            $("<div>", {
                class: "list-item-search"
            })
                .append('<input type="text" placeholder="Поиск">')
                .prependTo(createSelectList);

            $("<div>", {
                class: "list-item-create"
            })
                .append($("<a>", {
                    href: "/",
                    class: "link-create-show",
                    text: "Создать своё направление"
                })
                    .prepend($("<span>", {
                        class: "item-icon"
                    })
                        .append('<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.4375 11H18.5625" stroke="#9BB3E3" stroke- width="2" stroke - linecap="round" stroke - linejoin="round" /><path d="M11 3.4375V18.5625" stroke="#9BB3E3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg >'))).appendTo(createSelectList);

            $("<div>", {
                class: "list-item-add"
            })
                .append('<input type="text" name="directionItemAdd">')
                .append($('<span>')
                    .append('<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width = "40" height = "40" rx = "5" fill = "#F9FCFF" /><path d="M17.1464 24.3184L17.4999 24.672L17.8535 24.3184L28.9901 13.1806L30.0514 14.2413L17.4999 26.7928L10.252 19.5449L11.3124 18.4845L17.1464 24.3184Z" fill="#9BB3E3" stroke="#9BB3E3" /></svg >')).insertAfter('.list-item-create');

        } else if (_this[0].name === "kategorySelect" || _this[0].name === "serviceSelect" || _this[0].name === "providerSelect" || _this[0].name === "invalidSelect" || _this[0].name === "kategoryInvalidSelect" || _this[0].name === "districtSelect") {

            $("<div>", {
                class: "list-item-search"
            })
                .append('<input type="text" placeholder="Поиск">')
                .prependTo(createSelectList);

        }

        const selectItem = selectList.find(".new-select__item");

        selectList.slideUp(0);
        selectHead.on("click", function (event) {
            $(".new-select").not($(event.target)).removeClass("on");
            $(".new-select__list").not($(event.target)).slideUp(duration)
            if (!$(this).hasClass("on")) {
                $(this).addClass("on");
                selectList.slideDown(duration);
            } else {
                $(this).removeClass("on");
                selectList.slideUp(duration);
            }
        });
        selectItem.on("click", function () {
            let $this = $(this);
            let chooseItem = $this.data("value");
            let $trueSelect = $(selectList).siblings("select");
            selectHead.text($this.find("span").text());
            selectList.slideUp(duration);
            selectHead.removeClass("on");
            $trueSelect.val(chooseItem).prop("selected", true);
            $trueSelect.trigger("change");
        });
    });
}

function initAjaxInput() {
    const $ajaxSection = $("#ajax-section");
    const $selectContainer = $ajaxSection.closest(".select");
    const $selectContainerClick = $selectContainer.siblings(".new-select__list").find(".new-select__item");
    let currentAjaxSectionValue = parseInt($ajaxSection.find("option:selected").attr("value"));
    $selectContainerClick.on("click", function (e) {
        e.preventDefault();
        e.stopPropagation();

        let id = $(this).data().value;
        if (id > 0 && id !== currentAjaxSectionValue) {
            currentAjaxSectionValue = id;
            BX.ajax.runComponentAction("mendeleev:profile.organization", "getSections", {
                mode: "ajax",
                data: {
                    idSection: id,
                }
            }).then(function (response) {
                let $parentInput = $("#parent-section");
                $parentInput.empty();
                //отрисовыеваем новые элементы
                updateElement("#parent-section", response.data);

                //обновляем элементы в обьекте input
                let idChangeInput = $parentInput.closest('.valid-checkbox-multiple').attr('id');
                let oCurrentCheckbox = {};
                Object.keys(collectionsForms).forEach(keyInput => {
                    oCurrentCheckbox = collectionsForms[keyInput].getInputById(idChangeInput);
                    oCurrentCheckbox.updateInputGroup(oCurrentCheckbox);
                })
            });
        }
    });
}

/* Функция обновления элементов в custom select*/
function updateElement(container, response) {
    let $this = $(container);
    response.forEach((res, idx) => {
        $this.append($("<li>", {
                class: "list-item-text",
                "data-value": res.ID
            })
                .append($("<input>", {
                    type: "checkbox",
                    id: `checkbox-direction-${res.ID}`,
                    value: res.ID,
                    "data-value-name": res.NAME,
                    name: "FIELDS[SECTION][]"
                }))
                .append($("<label>", {
                    for: `checkbox-direction-${res.ID}`,
                    text: res.NAME
                }))
        );
    });
    $("#" + $this.attr("data-error-wraper")).val("Направление");

    $("#parent-section input").on("change", (e) => {
        checkDirection();
    });
}

//Функция инициализует проверку формы
function initValidateForm() {
    let forms = $('.validate-form');
    forms.each(function (index, htmlForm) {
        collectionsForms[index] = new formValid(htmlForm);
    })
}

function tinyMCEAfterAjax() {
    let textArea = $("textarea")
    textArea.each(function (index, value) {
        let idEl = $(value).attr("id")
        if (idEl) {
            iniText(idEl)
        }
    })
}

function initCheckboxInput() {
    const $ajaxServiceElement = $("#ajax-service-elements");
    const $selectContainerElement = $ajaxServiceElement.closest(".select");
    const $selectContainerClickElement = $selectContainerElement.siblings(".new-select__list").find(".new-select__item");
    let currentAjaxSectionValueElement = parseInt($ajaxServiceElement.find("option:selected").attr("value"));
    let child_section = "service-child-section";
    $selectContainerClickElement.on("click", function (e) {
        e.preventDefault();
        e.stopPropagation();

        let id = $(this).data().value;
        if (id > 0 && id !== currentAjaxSectionValueElement) {
            currentAjaxSectionValueElement = id;
            BX.ajax.runComponentAction("mendeleev:profile", "getElements", {
                mode: "ajax",
                data: {
                    idSection: id,
                }
            }).then(function (response) {
                BX.cleanNode(child_section)
                response.data.forEach(function (element, index) {
                    BX.prepend(BX.create(
                        "option", {
                            attrs: {
                                value: element.ID
                            },
                            text: element.NAME
                        }
                    ), BX(child_section))
                })
                $("#" + child_section).siblings(".new-select").remove();
                createNewElementSelect("#" + child_section);

            });
        }
    });
}

function initEventCheckbox() {
    /* События при работе с select при добавлении и редактировании направлений и услуг */
    $(".providing.fill-sections .list-item-text input").on("change", (e) => {
        checkNewsDirection("fill-sections");
    });
    $(".providing.list-invalid-gi .list-item-text input").on("change", (e) => {
        checkNewsDirection("list-invalid-gi");
    });
    $(".providing.list-invalid-categoria .list-item-text input").on("change", (e) => {
        checkNewsDirection("list-invalid-categoria");
    });
    $(".providing.list-city .list-item-text input").on("change", (e) => {
        checkNewsDirection("list-city");
    });
    $("#parent-section .list-item-text input").on("change", (e) => {
        checkDirection();
    });
}

function checkNewsDirection(element) {
    let labelText = "";
    $(`.providing.${element} .list-item-text input[type='checkbox']:checked`).each(function (e) {
        if (labelText === "") {
            labelText += $(this).next("label").text();
        } else {
            labelText += ", " + $(this).next("label").text();
        }
    });
    let currentInputElement = $(`.direction-input-item.${element} input`);
    currentInputElement.val(labelText);
    currentInputElement.attr("title", labelText);
}

//добавляет выбранные название из писка в input для отображения
function checkDirection() {
    let labelText = "";
    $("#parent-section .list-item-text input[type='checkbox']:checked").each(function (e) {
        if (labelText === "") {
            labelText += $(this).data("value-name");
        } else {
            labelText += ", " + $(this).data("value-name");
        }
    });
    let currentInputElement = $(".direction-input-item input");

    currentInputElement.val(labelText);
    currentInputElement.attr("title", labelText);
}
/* События чтобы custom select своричилася при клике */
$(document).on("click", (e) => {
    e = e.originalEvent;
    if (e && !$(e.target).closest(".new-select__list").length && !$(e.target).closest(".new-select").length) {
        let $selectLists = $(".new-select__list");
        $selectLists.hide(450);
        $selectLists.prev(".new-select.on").removeClass("on");
    }
    if (e && !$(e.target).closest(".direction-input-item").length && !$(e.target).closest(".direction-list-item.providing").length) {
        let $selectList = $(".direction-list-item.providing");
        $selectList.hide(50);
        $selectList.prev(".direction-input-item").removeClass("active");
    }
    if (e && $(e.target).closest(".employees-burger.active")) {
        $(".employees-burger.active").removeClass("active");
    }
});
/* Перезагрузка страницы */
function updatePage() {
    window.location.reload();
}

function deletePhotoPost(element) {
    $(element).closest("form").find("input[name='old_preview']").val("")
    $(element).closest(".output-photo-file").empty()
}