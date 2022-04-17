<div class="create-product-modal modal-block hidden">
    <div class="edit-product-modal-inner">
        <i class="fa-solid fa-xmark edit-product-modal-cancel"></i>
        <div class="edit-product-modal-header" id="edit-product-modal-header">Добавить продукт</div>
        <div class="edit-product-modal-label">Артикул</div>
        <input type="text" class="edit-product-modal-input" id="articleInput">
        <div class="edit-product-modal-label">Название</div>
        <input type="text" class="edit-product-modal-input" id="nameInput">
        <div class="edit-product-modal-label">Доступность</div>
        <select type="text" class="edit-product-modal-input" id="availability">
            <option value="available">Доступен</option>
            <option value="unavailable">Не доступен</option>
        </select>
        <div class="edit-product-modal-attr">
            Атрибуты
        </div>
        <div class="edit-product-modal-attr-list" id="attrList">
        </div>
        <div>
            <div class="edit-product-modal-add" id="addAttr">
                + Добавить атрибут
            </div>
        </div>
        <ul class="modal-errors" id="modalErrors"></ul>
        <div class="modal-success text-success hidden" id="modalSuccess">
            Изменения применены!
        </div>
        <div class="right-menu-bar-btn" id="addProduct">
            Добавить
        </div>

        <div class="edit-product-modal-attr-row hidden align-items-center">
            <div>
                <div class="edit-product-modal-label">Название</div>
                <input type="text" class="edit-product-modal-input attr-name">
            </div>
            <div>
                <div class="edit-product-modal-label">Значение</div>
                <input type="text" class="edit-product-modal-input attr-value">
            </div>
            <div>
                <i class="fa-solid fa-trash"></i>
            </div>
        </div>
    </div>
</div>