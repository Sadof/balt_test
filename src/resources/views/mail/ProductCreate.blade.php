<h2>Был добавлен продукт.</h2>
<div style="margin-bottom: 5px;">ID: {{$data['id']}}</div>
<div style="margin-bottom: 5px;">Артикул: {{$data['ARTICLE']}}</div>
<div style="margin-bottom: 5px;">Название: {{$data['NAME']}}</div>
<div style="margin-bottom: 5px;">Статус: {{$data['STATUS'] =='available' ? 'Доступен' : 'Не доступен'}}</div>
@if (count(json_decode($data["DATA"], true)))
    <div style="margin-bottom: 5px;">Атрибуты:</div>
    <div style="margin-left: 15px;">
        @foreach (json_decode($data["DATA"]) as $name => $value)
        <div style="margin-bottom: 5px;">{{$name}} : {{$value}}</div>
        @endforeach
    </div>
@endif