$(function() {
    initPageEmployee();
});

//редактирование
$(document).on("submit","#modal-employees-edit-form" , function () {
    $('.jqm-modal').jqmHide();
    BX.addCustomEvent('onAjaxSuccess', initPageEmployee);
})
//добавление
$(document).on("submit" , "#form-add_new_employee" , function () {
    $('.jqm-modal').jqmHide();
    BX.addCustomEvent('onAjaxSuccess', initPageEmployee);
    // BX.addCustomEvent('onAjaxSuccess', showAfterAddUser)
})
//нажатие на все кноки после загрузи / ajax
function initPageEmployee() {

    //редактирование пользователя
    initEditUserButton();
    initDeleteUserButton();
    initAddUserButton();
    showAfterAddUser();
    $(".jqm-modal").jqm();
    BX.removeCustomEvent('onAjaxSuccess', initPageEmployee);
}

/* Функции после отработки ajax при редактировании сотрудника*/
function renderEditForm(objUser , form) {
    form.find("#employee-edit-id").val(objUser.ID);
    form.find("#employee-edit-name").val(objUser.NAME);
    form.find("#employee-edit-last_name").val(objUser.LAST_NAME);
    form.find("#employee-edit-second_name").val(objUser.SECOND_NAME);
    form.find("#employee-edit-personal_phone").val(objUser.PERSONAL_PHONE);
    form.find("#employee-edit-email").val(objUser.EMAIL);
    form.find("#employee-edit-status_str").val(objUser.UF_USER_STATUS_STR);
    if (objUser.UF_EMPLOYEE_SECTION_VALUE.length > 0) {
        objUser.UF_EMPLOYEE_SECTION_VALUE.forEach(function (element, idx) {
            BX.append(renderSection(element) , BX("employee-edit-list_section"));
        });
    }
    form.find("#employee-edit-list_section").val(objUser.NAME);

    checkAndFillSection();

    $("#employee-edit-list_section input").on("change", (e) => {
        checkAndFillSection();
    });

}

function checkAndFillSection() {
    let labelText = "";
    $("#employee-edit-list_section .list-item-text input[type='checkbox']:checked").each(function (e) {
        if (labelText === "") {
            labelText += $(this).data("value-name");
        } else {
            labelText += ", " + $(this).data("value-name");
        }
    });
    let currentInputElement = $(".direction-input-item.edit-section-input input");
    currentInputElement.val(labelText);
    currentInputElement.attr("title", labelText);
}

function renderSection(element) {
    let htmlEl = BX.create(
        "li", {
            props: {
                className: "list-item-text",
            },
            attrs: {
                "data-value": element.ID
            },
            children: [
                renderItemInput(element),
                BX.create(
                    "label", {
                        attrs: {
                            "for": "cb-status-emp-edit-" + element.ID
                        },
                        text: element.VALUE
                    }
                )
            ]
        }
    );
    return htmlEl;
}

function renderItemInput(element) {
    if (element.SELECTED === true ) {
        return BX.create(
            "input", {
                props: {
                    type: "checkbox",
                    name: "USER[PROPERTY][UF_EMPLOYEE_SECTION][]",
                    id: "cb-status-emp-edit-"+ element.ID,
                    value: element.ID,
                    "TEST": "234"
                },
                attrs: {
                    "checked": "checked"
                },
                dataset: {
                    valueName: element.VALUE,
                }
            }
        );
    } else {
        return BX.create(
            "input", {
                props: {
                    type: "checkbox",
                    name: "USER[PROPERTY][UF_EMPLOYEE_SECTION][]",
                    id: "cb-status-emp-edit-"+ element.ID,
                    value: element.ID,
                },
                dataset: {
                    valueName: element.VALUE,
                }
            }
        );
    }
}

function initEditUserButton() {
    /* Событие клика по кнопке редактировать в разделе "Сотрудники" */
    let target_form = $("#modal-employees-edit").jqm({ trigger: ".btn-edit-employee" });
    $(".btn-edit-employee").on("click",  function (event) {
        BX.ajax.runComponentAction( "mendeleev:profile.organization.employee", "getInfoUser", {
            mode: "ajax",
            data: {
                idGetUser: $(this).attr("data-user")
            }
        }).then(function (response) {
            if (response.data) {

                $("#employee-edit-list_section").empty();
                renderEditForm(response.data , target_form);
                $(".modal-popup-edit").jqmShow();
            }
        });
    });
}

function initDeleteUserButton() {
    /* Событие клика по кнопке удалить в разделе "Сотрудники" */
    $(document).on("click", ".btn-delete" ,  function (event) {
        let userID = $(this).attr("data-user");
        BX.ajax.runComponentAction( "mendeleev:profile.organization.employee", "deleteUser", {
            mode: "ajax",
            data: {
                idUser: userID
            }
        }).then(function (response) {
            BX.addCustomEvent("onAjaxSuccess", function() {
                $(".show-employees-delete-modal").jqmHide();
                // window.location.reload();
                $("[data-user-id="+ userID+"]").remove();
            });
        });
    });
    /* Событие клика по кнопке удалить в модальном окне в разделе "Сотрудники" */
    $(document).on("click", ".btn-delete-employee", function(e){
        let currentUser = $(this).data("user");
        $(".btn-delete").attr("data-user", currentUser);
        $(".show-employees-delete-modal").jqm();
        $(".show-employees-delete-modal").jqmShow();
    });
}

function initAddUserButton() {
    $('#modal-employees-add').jqm();
    /* Событие клика по кнопке добавить сотрудника в разделе "Сотрудники" */
    $("#button-employees-add").on("click", function (e) {
        let sectionInput = $(".list-item-text input[type='checkbox']:checked");
        sectionInput.prop("checked", false);
        $("#modal-employees-add").jqmShow();
    });
}

function showAfterAddUser() {
    $('.jqm-modal').jqmHide();
    let $employeesSuccessModal = $("#modal-employees-add-result");
    if ($employeesSuccessModal.length) {
        $employeesSuccessModal.jqm();
        $employeesSuccessModal.jqmShow();
    }
    $(".btn-add").on("click", function (e) {
        $employeesSuccessModal.jqmHide();
    });

}
