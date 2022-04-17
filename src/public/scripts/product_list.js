window.addEventListener('DOMContentLoaded', () => {
    const addAttrBtn = document.querySelector("#addAttr");
    const attrRowToCopy = document.querySelector(".edit-product-modal-attr-row.hidden");
    const attrList = document.querySelector("#attrList");
    const modalCancel = document.querySelector(".edit-product-modal-cancel");
    const modalOpen = document.querySelector("#openModal");
    const modal = document.querySelector(".create-product-modal");
    const modalShow = document.querySelector(".show-product-modal");
    const modalErrors = document.querySelector("#modalErrors");
    const modalSuccess = document.querySelector("#modalSuccess");
    const addProduct = document.querySelector("#addProduct");
    const articleInput = document.querySelector("#articleInput");
    const nameInput = document.querySelector("#nameInput");
    const availabilityInput = document.querySelector("#availability");
    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const productRows = document.querySelectorAll(".main-section-products-row");
    const showModalDelete = document.querySelector("#show-modal-delete");
    const showModalId = document.querySelector("#show-modal-id");
    const showModalCancel = document.querySelector("#show-product-modal-cancel");
    const showModalEdit = document.querySelector("#show-modal-edit");
    const editProductModalHeader = document.querySelector("#edit-product-modal-header");
    const productRowHidden = document.querySelector(".main-section-products-row.hidden");
    const productList = document.querySelector(".main-section-products-list");
    const attrItemHidden = document.querySelector(".main-section-products-row-item-attr.hidden");
    let loading = false;
    let selectedProductObj = {};

    addAttrBtn.addEventListener("click", (e) => {
        createEditModalRow()
    })

    function createEditModalRow(name = null, value = null) {
        let copy = attrRowToCopy.cloneNode(true);
        if (name && value) {
            copy.querySelector(".attr-name").value = name;
            copy.querySelector(".attr-value").value = value;
        }
        revealObject(copy);
        copy.querySelector(".fa-trash").addEventListener("click", function(event) {
            deleteRow(event);
        });
        attrList.appendChild(copy);
    }

    function deleteRow(event) {
        let elem = event.target;
        elem.parentElement.parentElement.remove();
    }

    modalOpen.addEventListener("click", () => {
        revealObject(modal);
        hideObject(modalShow);

        if (!chechIfObjEmpty(selectedProductObj)) {
            selectedProductObj = {};
            clearModal();
        }
    })

    modalCancel.addEventListener("click", () => {
        hideObject(modal);

        if (!chechIfObjEmpty(selectedProductObj)) {
            selectedProductObj = {};
            clearModal();
        }
    })

    showModalCancel.addEventListener("click", () => {
        hideObject(modalShow);
    })

    function hideObject(obj) {
        if (!obj.classList.contains("hidden")) {
            obj.classList.add("hidden");
        }
    }

    function revealObject(obj) {
        if (obj.classList.contains("hidden")) {
            obj.classList.remove("hidden");
        }
    }

    addProduct.addEventListener("click", () => {
        sendRequest();
    })
    async function sendRequest() {
        if (loading) {
            return;
        }
        let form_data = validateForm();
        let errors = [];

        if (form_data) {
            let create = chechIfObjEmpty(selectedProductObj)
            let url = "";
            try {
                if (!create) {
                    form_data.id = selectedProductObj.id;
                    url = "/" + selectedProductObj.id;
                }
                loading = true;
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Content-Type': 'application/json',
                    },

                    body: JSON.stringify(form_data)
                });
                const data = await response.json();

                if (response.status == 422) {
                    if (data && data.errors) {
                        for (const [key, value] of Object.entries(data.errors)) {
                            errors.push(value);
                        }
                        showErrors(errors);
                    }
                    return;
                }

                if (data.status != "ok") {
                    throw new Error;
                }

                if (create) {
                    let copy = productRowHidden.cloneNode(true);
                    updateProductRow(copy, form_data["ARTICLE"], form_data["NAME"],
                        form_data["AVAILABLE"], JSON.parse(form_data["ATTRS"]), data["product_id"]);
                    productList.prepend(copy);
                    revealObject(copy);
                    copy.addEventListener("click", event => {
                        productRowEvent(event);
                    })
                    clearModal();
                    hideObject(modal);
                } else {
                    let row = document.querySelector(
                        `.main-section-products-row[data-id="${selectedProductObj.id}"]`
                    );
                    updateProductRow(row, form_data["ARTICLE"], form_data["NAME"],
                        form_data["AVAILABLE"], JSON.parse(form_data["ATTRS"]),
                        selectedProductObj.id);

                    revealObject(modalSuccess);
                    setTimeout(() => {
                        hideObject(modalSuccess)
                    }, 5000);
                }

            } catch (err) {
                showErrors(["Ошибка приложения. Пожалуйста отбратитесь в техническую поддержку."]);
            } finally {
                loading = false;
            }
        }
    }

    function validateForm() {
        let nameValue = nameInput.value;
        let articleValue = articleInput.value;
        let availabilityValue = availabilityInput.value;
        let re = /^[A-Za-z0-9]+$/;
        let errors = [];
        let attrRows = document.querySelectorAll(
            ".edit-product-modal-attr-list .edit-product-modal-attr-row");
        let attrNameCheck = false;
        let attrValueCheck = false;
        let attrs = {};
        let form_data = {};

        modalErrors.querySelectorAll("li").forEach(elem => {
            elem.remove();
        })

        removeInputError();

        if (!nameValue || nameValue.length < 10) {
            nameInput.classList.add("errorInput");
            errors.push("Название должно быть длинной от 10 символов");
        }

        if (!articleValue || !articleValue.match(re)) {
            articleInput.classList.add("errorInput");
            errors.push("Артикул должен содержать только латинские символы и цифры");
        }

        attrRows.forEach(elem => {
            let attrName = elem.querySelector(".attr-name");
            let attrValue = elem.querySelector(".attr-value");
            let attrNameValue, attrValueValue;
            if (!attrName.value || !attrName.value.length) {
                attrNameCheck = true;
                attrName.classList.add("errorInput");
            } else {
                attrNameValue = attrName.value;
            }
            if (!attrValue.value || !attrValue.value.length) {
                attrValueCheck = true;
                attrValue.classList.add("errorInput");
            } else {
                attrValueValue = attrValue.value;
            }
            if (attrNameValue && attrValueValue) {
                attrs[attrNameValue] = attrValueValue;
            }
        });

        if (attrNameCheck) {
            errors.push("Не указано имя в атрибутах");
        }
        if (attrValueCheck) {
            errors.push("Не указано значение в атрибутах");
        }

        if (!errors.length) {
            form_data = {
                "NAME": nameValue,
                "ARTICLE": articleValue,
                "AVAILABLE": availabilityValue,
                "ATTRS": JSON.stringify(attrs)
            }
            return form_data;
        } else {
            showErrors(errors);
            return false;
        }
    }

    function showErrors(errors) {
        errors.forEach(err => {
            var li = document.createElement("li");
            li.innerHTML = err;
            modalErrors.appendChild(li);
        })
    }

    function updateProductRow(obj, article, name, status, attrs, id) {
        let attrs_item = obj.querySelector("[name='ATTRS']");

        obj.querySelector("[name='ARTICLE']").innerHTML = article;
        obj.querySelector("[name='NAME']").innerHTML = name;
        obj.querySelector("[name='STATUS']").innerHTML = status == 'available' ? 'Доступен' : 'Не доступен';
        obj.querySelector("[name='ID']").value = id;
        obj.setAttribute("data-id", id);

        attrs_item.innerHTML = null;
        if (chechIfObjEmpty(attrs)) {
            attrs_item.innerHTML = "-";
        } else {
            for (const [key, value] of Object.entries(attrs)) {
                let copy = attrItemHidden.cloneNode(true);
                copy.innerHTML = key + " : " + value;
                attrs_item.append(copy);
                revealObject(copy);
            }
        }
    }

    function removeInputError() {
        let elems = modal.querySelectorAll(".errorInput");
        elems.forEach((elem) => {
            elem.classList.remove("errorInput");
            modalShow.querySelector("#show-modal-id")
        })
    }


    function clearModal() {
        availabilityInput.value = "available";
        attrList.innerHTML = null;
        nameInput.value = null;
        articleInput.value = null;
        modalErrors.innerHTML = null;
        addProduct.innerHTML = "Добавить";
        editProductModalHeader.innerHTML = "Добавить продукт";
        removeInputError();
    }


    productRows.forEach(row => {
        row.addEventListener("click", event => {
            productRowEvent(event);
        })
    })

    function productRowEvent(event) {
        let target = event.currentTarget;
        let attrs = {};
        selectedProductObj.article = target.querySelector("[name='ARTICLE']").innerHTML.trim();
        selectedProductObj.name = target.querySelector("[name='NAME']").innerHTML.trim();
        selectedProductObj.status = target.querySelector("[name='STATUS']").innerHTML.trim();
        target.querySelectorAll("[name='ATTRS'] div").forEach(elem => {
            let split = elem.innerHTML.trim().split(":");
            attrs[split[0].trim()] = split[1].trim();
        })

        selectedProductObj.attrs = attrs;
        selectedProductObj.id = target.querySelector("[name='ID']").value;

        modalShow.querySelector("#show-modal-article").innerHTML = selectedProductObj
            .article;
        modalShow.querySelector("#show-modal-name").innerHTML = selectedProductObj.name;
        modalShow.querySelector("#show-product-modal-header").innerHTML =
            selectedProductObj.name;
        modalShow.querySelector("#show-modal-status").innerHTML = selectedProductObj
            .status;
        modalShow.querySelector("#show-modal-attrs").innerHTML = target.querySelector(
            "[name='ATTRS']").innerHTML;
        showModalId.value = selectedProductObj.id;

        revealObject(modalShow);
        hideObject(modal);
    }

    // Удаление продукта
    if (showModalDelete) {
        showModalDelete.addEventListener("click", event => {
            deleteRequest();
        })
    }

    async function deleteRequest() {
        let id_to_delete = showModalId.value;
        if (id_to_delete) {
            try {
                const response = await fetch(`/${id_to_delete}`, {
                    method: 'delete',
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                })
                const data = await response.json();

                if (data.status != "ok") {
                    throw new Error;
                }
                hideObject(modalShow);
                document.querySelector(
                        `.main-section-products-row[data-id="${id_to_delete}"]`)
                    .remove();
            } catch (err) {
                alert("Ошибка при удалении продукта");
            }

        }
    }
    if (showModalEdit) {
        showModalEdit.addEventListener("click", event => {
            clearModal();
            editProductModalHeader.innerHTML = `Редактировать ${selectedProductObj.name}`;
            addProduct.innerHTML = `Редактировать`;
            articleInput.value = selectedProductObj.article;
            nameInput.value = selectedProductObj.name;
            availabilityInput.value = selectedProductObj.status == "Доступен" ? "available" :
                "unavailable";
            for (const [key, value] of Object.entries(selectedProductObj.attrs)) {
                createEditModalRow(key, value);
            }
            hideObject(modalShow);
            revealObject(modal)
        })
    }

    function chechIfObjEmpty(obj) {
        return Object.keys(obj).length === 0 ? true : false;
    }
});