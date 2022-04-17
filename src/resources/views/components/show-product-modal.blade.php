<div class="show-product-modal modal-block hidden">
    <div class="edit-product-modal-inner">
        <div class="show-product-modal-header" id="show-product-modal-header">
        </div>
        <div class="show-product-modal-btns">
            @if (Auth::user()->role == 'admin')
                <i class="fa-solid fa-pen-to-square" id="show-modal-edit"></i>
                <i class="fa-solid fa-trash" id="show-modal-delete"></i></i>
            @endif
            <i class="fa-solid fa-xmark show-product-modal-cancel" id="show-product-modal-cancel"></i>
        </div>

        <div class="edit-product-modal-row row">
            <div class="col-2">Артикул</div>
            <div class="col-10" id="show-modal-article"></div>
        </div>
        <div class="edit-product-modal-row row">
            <div class="col-2">Название</div>
            <div class="col-10" id="show-modal-name"></div>
        </div>
        <div class="edit-product-modal-row row">
            <div class="col-2">Статус</div>
            <div class="col-10" id="show-modal-status"></div>
        </div>
        <div class="edit-product-modal-row row">
            <div class="col-2">Атрибуты</div>
            <div class="col-10" id="show-modal-attrs"></div>
        </div>
        <input type="hidden" id="show-modal-id" value="">
    </div>
</div>