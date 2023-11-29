<div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h6 class="mb-0">
        <a class="" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Stock
        </a>
      </h6>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
          <table class="table table-hover table-sm table-responsive" id="tableStocks">
            <thead>
              <tr>
                <th>Almacén <button type="button" class="btn btn-default btn-xs" id="btnNewStock">{!! config('options.icons.add') !!}</button></th>
                <th>Stock</th>
                <th>Stock Mínimo</th>
                <th>Stock Máximo</th>
                <th>Valor Promedio (S/)</th>
              </tr>
            </thead>
            <tbody id="tbodyStocks">
              @foreach($warehouses as $w)
                <tr data-id="">
                  <input type="hidden" name="stocks[{{ $w->id }}][warehouse_id]" value="{{ $w->id }}">
                  @php
                  $stock = null;
                  if(isset($model)){
                    $stock = $model->stocks->where('warehouse_id', $w->id)->first();
                  }
                  @endphp
                  @if($stock)
                    <input type="hidden" name="stocks[{{ $w->id }}][id]" value="{{ $stock->id }}">
                    <input type="hidden" name="stocks[{{ $w->id }}][warehouse_id]" value="{{ $stock->warehouse_id }}">
                    <td align="center">{{ $w->name }}</td>
                    <td align="center">{{ $stock->stock }}</td>
                    <td>{!! Form::number('stocks['.$w->id.'][stock_min]', $stock->stock_min, ['class'=>"form-control form-control-sm"]) !!}</td>
                    <td>{!! Form::number('stocks['.$w->id.'][stock_max]', $stock->stock_max, ['class'=>"form-control form-control-sm"]) !!}</td>
                    <td align="center">{{ $stock->avarage_value }}</td>
                  @else
                    <td align="center">{{ $w->name }}</td>
                    <td align="center">{!! Form::number('stocks['.$w->id.'][stock]', 0, ['class'=>"form-control form-control-sm"]) !!}</td>
                    <td>{!! Form::number('stocks['.$w->id.'][stock_min]', 0, ['class'=>"form-control form-control-sm"]) !!}</td>
                    <td>{!! Form::number('stocks['.$w->id.'][stock_max]', 0, ['class'=>"form-control form-control-sm"]) !!}</td>
                    <td align="center">0.00</td>
                  @endif
                </tr>
              @endforeach
            </tbody>
          </table>
          {!! Form::hidden('items', $w->id, ['id'=>'items']) !!}
      </div>
    </div>
  </div>

  @if(1==0)
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h6 class="mb-0">
        <a class="collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Accesorios
        </a>
      </h6>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
          <table class="table table-hover table-sm table-responsive" id="tableAccessories">
            <thead>
              <tr>
                <th>Código <button type="button" class="btn btn-default btn-sm" id="btnNewAccessory">{!! $icons['add'] !!}</button></th>
                <th>Accesorio</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody id="tbodyAccessories">
              @php $i=0; @endphp
              @if(isset($model))
              @foreach($model->accessories as $key => $accessory)
              <tr data-id="{{ $accessory->id }}">
                {!! Form::hidden("details[$i][id]", $accessory->id, ['class'=>'','data-accessoryid'=>'']) !!}
                <td>{{ $accessory->accessory->intern_code }} </td>
                <td>{{ $accessory->accessory->name }} </td>
                <td>
                  <div class="checkbox"><label>{!! Form::checkbox('accessories['.$i.'][is_deleted]', null, false, ['class'=>'isDeleted', 'data-isdeleted'=>'']); !!} Eliminar</label></div>
                  <input type="hidden" name="accessories[{{ $key }}][accessory_id]" value="{{ $accessory->accessory_id }}">
                  <input type="hidden" name="accessories[{{ $key }}][id]" value="{{ $accessory->id }}">
                </td>
              </tr>
              @php $i++; @endphp
              @endforeach
              @endif
              {!! Form::hidden('items-accessory', $i, ['id'=>'items-accessory']) !!}
            </tbody>
          </table>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h6 class="mb-0">
        <a class="collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Atributos
        </a>
      </h6>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">
          <table class="table table-hover table-sm table-responsive" id="tableAttributes">
            <thead>
              <tr>
                <th>Nombre <button type="button" class="btn btn-default btn-sm" id="btnNewAttribute">{!! $icons['add'] !!}</button></th>
                <th>Valor</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody id="tbodyAttributes">
              @php $i=0; @endphp
              @if(isset($model))
              @foreach($model->tables->where('type','attributes') as $key => $attribute)
              <tr data-id="{{ $attribute->id }}">
                {!! Form::hidden("attributes[$i][id]", $attribute->id, ['class'=>'','data-accessoryid'=>'']) !!}
                <td>{!! Form::text('attributes['.$i.'][name]', $attribute->name, ['class'=>"form-control form-control-sm"]) !!}</td>
                <td>{!! Form::text('attributes['.$i.'][value_1]', $attribute->value_1, ['class'=>"form-control form-control-sm"]) !!}</td>
                <td>
                  <div class="checkbox"><label>{!! Form::checkbox('attributes['.$i.'][is_deleted]', null, false, ['class'=>'isDeleted', 'data-isdeleted'=>'']); !!} Eliminar</label></div>
                </td>
              </tr>
              @php $i++; @endphp
              @endforeach
              @endif
              {!! Form::hidden('items-attribute', $i, ['id'=>'items-attribute']) !!}
            </tbody>
          </table>

      </div>
    </div>
  </div>
  @endif
</div>

<template id="template-row-accessory">
  <tr data-id="">
    <td><span class='form-control form-control-sm text-right internCode' data-labelCode></span></td>
    <td>{!! Form::text('data1', null, ['class'=>'form-control form-control-sm txtAccessory', 'data-accessory'=>'', 'required'=>'required']); !!}</td>
    <td>
      <div class="checkbox"><label>{!! Form::checkbox('is_deleted', null, false, ['class'=>'isDeleted', 'data-isdeleted'=>'']); !!} Eliminar</label></div>
      {!! Form::hidden('data2', null, ['class'=>'accessoryId', 'data-accessoryid'=>'']); !!}
    </td>
  </tr>
</template>

<template id="template-row-attribute">
  <tr data-id="">
    <td>{!! Form::text('data1', null, ['class'=>'form-control form-control-sm txtName', 'data-name'=>'', 'required'=>'required']); !!}</td>
    <td>{!! Form::text('data2', null, ['class'=>'form-control form-control-sm txtValue', 'data-value'=>'', 'required'=>'required']); !!}</td>
    <td>
      <div class="checkbox"><label>{!! Form::checkbox('is_deleted', null, false, ['class'=>'isDeleted', 'data-isdeleted'=>'']); !!} Eliminar</label></div>
      {!! Form::hidden('data3', null, ['class'=>'attributeId', 'data-attributeid'=>'']); !!}
    </td>
  </tr>
</template>