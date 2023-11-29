@php
    $classes = 'form-check-input';
    if ($hasErrors) {
        $classes .= ' is-invalid';
    }
@endphp
@foreach($radios as $radio)
    <div class="custom-control custom-radio">
        {!! Form::radio(
            $radio['name'],
            $radio['value'],
            $radio['selected'],
            ['class' => $classes.' custom-control-input', 'id' => $radio['id']]) !!}
        <label class="custom-control-label" for="{{ $radio['id'] }}">
            {{ $radio['label'] }}
        </label>
    </div>
@endforeach
