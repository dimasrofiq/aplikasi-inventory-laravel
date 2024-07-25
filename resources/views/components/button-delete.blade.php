<a href="#" onclick="deleteData({{ $id }})" {{ $attributes->merge(['class' => 'py-2']) }}>
    <i class="fas fa-trash mr-1"></i>
    {{ $title }}
</a>
<form id="delete-form-{{ $id }}" action="{{ $url }}" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>
