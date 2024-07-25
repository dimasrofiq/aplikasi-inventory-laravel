<a href="#" {{ $attributes->merge(['class' => 'py-2']) }} data-toggle="modal"
    data-target="#modal-simple{{ $id }}">
    <i class="fas fa-{{ $icon }} {{ $style }}"></i>
    {{ $title }}
</a>
