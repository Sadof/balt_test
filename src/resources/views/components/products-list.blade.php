<div>
    <div class="main-section-products">
        <div class="main-section-products-header row">
            <div class="col-3 main-section-products-header-item">АРТИКУЛ</div>
            <div class="col-3 main-section-products-header-item">НАЗВАНИЕ</div>
            <div class="col-3 main-section-products-header-item">СТАТУС</div>
            <div class="col-3 main-section-products-header-item">АТРИБУТЫ</div>
        </div>
        <div class="main-section-products-list">
            @foreach ($products as $product)
                <div class="main-section-products-row row" data-id="{{ $product->id }}">
                    <div class="main-section-products-row-item col-3" name="ARTICLE">
                        {{ $product->ARTICLE }}
                    </div>
                    <div class="main-section-products-row-item col-3" name="NAME">
                        {{ $product->NAME }}
                    </div>
                    <div class="main-section-products-row-item col-3" name="STATUS">
                        {{ $product->STATUS == 'available' ? 'Доступен' : 'Не доступен' }}
                    </div>
                    <div class="main-section-products-row-item col-3" name="ATTRS">
                        @if (count((array) json_decode($product->DATA)))
                            @foreach (json_decode($product->DATA) as $name => $value)
                                <div name="main-section-products-row-item-attr">{{ $name }} :
                                    {{ $value }}</div>
                            @endforeach
                        @else
                            <span>-</span>
                        @endif
                    </div>
                    <input type="hidden" value="{{ $product->id }}" name="ID">
                </div>
            @endforeach
        </div>
    </div>
    <div class="main-section-products-row row hidden" data-id="">
        <div class="main-section-products-row-item col-3" name="ARTICLE">
        </div>
        <div class="main-section-products-row-item col-3" name="NAME">
        </div>
        <div class="main-section-products-row-item col-3" name="STATUS">
        </div>
        <div class="main-section-products-row-item col-3" name="ATTRS">
        </div>
        <input type="hidden" value="" name="ID">
    </div>
    <div class="main-section-products-row-item-attr hidden"></div>
</div>
