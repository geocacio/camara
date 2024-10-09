@props([
    'modalId' => 'modalId', 
    'modalTitle' => 'Modal Title', 
    'formAction' => '#', 
    'closeText' => 'Fechar', 
    'saveText' => 'Salvar mudanças',
    'itemsList' => [],
])

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $modalId }}Label">{{ $modalTitle }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="overflow-y: auto; max-height: 70vh;">
                <form action="{{ $formAction }}" method="post" enctype="multipart/form-data">
                    @csrf

                    {{ $slot }}

                    <button type="submit" class="btn btn-primary">{{ $saveText }}</button>

                </form>

                {{ $list }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ $closeText }}</button>
            </div>
        </div>
    </div>
</div>

<script>
    function openPopup(id) {
        document.getElementById('popup-' + id).style.display = 'block';
    }

    function closePopup(id) {
        document.getElementById('popup-' + id).style.display = 'none';
    }
</script>