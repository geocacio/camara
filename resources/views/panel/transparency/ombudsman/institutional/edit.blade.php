@extends('panel.index')
@section('pageTitle', 'Ouvidoria Institucional')

@section('content')
<div class="card">

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            <li>{{ $errors->first() }}</li>
        </ul>
    </div>
    @endif

    <div class="card-body">

        <form id="formOmbudsmanInstitutional" class="form-multple-items" action="{{ route('ombudsman-institutional.update', $ombudsman_institutional->slug) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')            

            <input type="hidden" name="descriptions">
            <div class="form-group">
                <label>Título Principal</label>
                <input type="text" name="main_title" class="form-control" autocomplete="off" value="{{ old('main_title', $ombudsman_institutional->main_title) }}">
            </div>

            <div class="form-group">
                <label>Título</label>
                <input type="text" name="title" class="form-control" autocomplete="off" value="{{ old('title', $ombudsman_institutional->title) }}">
            </div>

            <div class="container-items">
                <div class="items">
                    
                @if($ombudsman_institutional->descriptions == '')
                    <div class="item">
                        <div class="form-group">
                            <label>Título</label>
                            <input type="text" name="item_title" class="form-control" autocomplete="off" value="{{ old('item_title') }}">
                        </div>

                        <div class="form-group">
                            <label>Checklist</label>
                            <div class="d-flex align-items-center justify-content-center w-fit-content actions">
                                <div class="toggle-switch cmt-4">
                                    <input type="checkbox" id="checklist" name="checklist" class="toggle-input">
                                    <label for="checklist" class="toggle-label no-margin"></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Descrição</label>
                            <textarea name="item_description" class="form-control">{{ old('item_description') }}</textarea>
                        </div>
                    </div>
                    @else
                    @foreach(json_decode($ombudsman_institutional->descriptions) as $index => $description)
                    <div class="item">
                        <div class="form-group">
                            <label>Título</label>
                            <input type="text" name="item_title_{{ $index + 1 }}" class="form-control" value="{{ $description->input_value }}">
                        </div>

                        <div class="form-group">
                            <label>Checklist</label>
                            <div class="d-flex align-items-center justify-content-center w-fit-content actions">
                                <div class="toggle-switch cmt-4">
                                    <input type="checkbox" id="checklist_{{ $index + 1 }}" name="checklist_{{ $index + 1 }}" class="toggle-input" {{ $description->checklist ? 'checked' : ''}}>
                                    <label for="checklist_{{ $index + 1 }}" class="toggle-label no-margin"></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Descrição</label>
                            <textarea name="item_description_{{ $index + 1 }}" class="form-control">{{ $description->textarea_value }}</textarea>
                        </div>

                        <!-- Botão de remover (opcional) -->
                        <button class="remove-button" onclick="removeItem(event)"><i class="fa-sharp fa-solid fa-xmark"></i></button>
                    </div>
                    @endforeach
                    @endif
                </div>
                <div class="container-button"><button onclick="newItem(event)">+</button></div>
            </div>

        </form>
        <div class="form-footer text-right">
            <button type="button" class="btn-submit-default" onclick="submit()">Guardar</button>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function removeItem(event) {
        event.preventDefault();
        const allItems = document.querySelectorAll('.container-items .items .item');
        console.log(allItems)
        if (allItems.length > 1) {
            const item = event.target.closest('.item');
            item.remove();
        } else {
            allItems[0].getElementsByTagName('input')[0].value = '';
            allItems[0].getElementsByTagName('textarea')[0].value = '';
        }
    }

    function newItem(e) {
        e.preventDefault();
        const container = e.target.closest('.container-items');
        const items = container.querySelector('.items');
        const item = items.querySelector('.item');
        const newItem = item.cloneNode(true);

        const totalItems = items.querySelectorAll('.item').length + 1;
        const inputName = newItem.getElementsByTagName('input')[0].value = '';
        newItem.getElementsByTagName('input')[0].setAttribute('name', inputName + '_' + totalItems);

        const textareaName = newItem.getElementsByTagName('textarea')[0].getAttribute('name');
        newItem.getElementsByTagName('textarea')[0].value = '';
        newItem.getElementsByTagName('textarea')[0].setAttribute('name', textareaName + '_' + totalItems);

        const checklist = newItem.querySelector('input[type="checkbox"]');
        checklist.name = checklist.name + '_' + totalItems;
        checklist.id = checklist.id + '_' + totalItems;
        checklist.checked = false;
        const forChecklist = newItem.querySelector('.toggle-label');
        forChecklist.setAttribute('for', checklist.name);

        if (newItem.querySelector('.remove-button')) {
            newItem.querySelector('.remove-button').remove();
        }

        // Adicionar o botão de remoção ao novo item clonado
        const removeButton = document.createElement('button');
        removeButton.innerHTML = '<i class="fa-sharp fa-solid fa-xmark"></i>';
        removeButton.classList.add('remove-button');
        removeButton.addEventListener('click', (event) => removeItem(event)); // Aqui atribuímos o evento de clique para a função removeItem
        newItem.appendChild(removeButton);

        items.appendChild(newItem);
    }

    function submit() {
        const form = document.querySelector('#formOmbudsmanInstitutional');

        let arrItems = [];
        const allItems = document.querySelectorAll('.container-items .items .item');
        allItems.forEach((item, index) => {
            arrItems.push({
                'input_value': item.getElementsByTagName('input')[0].value,
                'checklist': item.querySelector('input[type="checkbox"]').checked ? 1 : 0,
                'textarea_value': item.getElementsByTagName('textarea')[0].value
            });

            if (index > 0) {
                item.remove();
            }
        });

        document.querySelector('input[name="descriptions"]').value = JSON.stringify(arrItems);
        form.submit();
    }
</script>
@endsection