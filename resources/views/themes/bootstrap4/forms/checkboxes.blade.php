@php
    $classes = 'form-check-input';
    if ($hasErrors) {
        $classes .= ' is-invalid';
    }
@endphp
@foreach($checkboxes as $checkbox)
    <div class="custom-control custom-checkbox">
        {!! Form::checkbox(
            $checkbox['name'],
            $checkbox['value'],
            $checkbox['checked'],
            ['class' => $classes.' custom-control-input', 'id' => $checkbox['id']]
        ) !!}
        <label class="custom-control-label" for="{{ $checkbox['id'] }}">
            {{ $checkbox['label'] }}
        </label>
    </div>
@endforeach
