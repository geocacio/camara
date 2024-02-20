@extends('panel.index')

@section('pageTitle', 'Atualizar arquivo')
@section('breadcrumb')
<li><a href="{{ route('biddings.index') }}">Licitações</a></li>
<li><a href="{{ route('biddings.available.files.index', $bidding->slug) }}">Arquivos disponíveis</a></li>
<li><span>Atualizar arquivo</span></li>
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                <li>{{ $errors->first() }}</li>
            </ul>
        </div>
        @endif

        <form action="{{ route('biddings.available.files.update', ['bidding' => $bidding->slug, 'id' => $file->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nome do arquivo</label>
                        {{-- <select name="name" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($category->children as $category)
                            <option value="{{ $category->name }}" {{ $file->name == $category->name ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select> --}}
                        <input type="text" class="form-control" name="name" value="{{ $file->name }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-0 d-flex align-items-center justify-content-center h-100 flex-direction-column">
                        <input type="file" name="file" id="file-authorization" style="display: none;" accept=".pdf" onchange="sendFile(event)">
                        <button class="btn btn-primary btn-new-file text-white" onclick="event.preventDefault(); document.getElementById('file-authorization').click();"><i class="fa-solid fa-upload"></i></button>
                        <a href="#" class="btn btn-link" data-toggle="modal" data-target="#showModal">{{ pathinfo($file->url, PATHINFO_FILENAME) }}</a>
                    </div>

                    <div class="modal fade modal-preview-file" id="showModal" tabindex="-1" role="dialog" aria-labelledby="fileModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @if (pathinfo($file->url, PATHINFO_EXTENSION) === 'pdf')
                                    <embed src="{{ asset('storage/'.$file->url) }}" width="100%" height="500px" type="application/pdf">
                                    @elseif (in_array(pathinfo($file->url, PATHINFO_EXTENSION), ['doc', 'docx']))
                                    <iframe src="https://view.officeapps.live.com/op/view.aspx?src={{ urlencode(asset('storage/' .$file->url)) }}" width="100%" height="500px"></iframe>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Descrição</label>
                <textarea name="description" class="form-control">{{ old('description', $file->description) }}</textarea>
            </div>

            <div class="form-footer text-right">
                <button type="submit" class="btn-submit-default">Guardar</button>
            </div>
        </form>
    </div>


    <div class="modal fade modal-lg" id="titleFile" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center" id="exampleModalLongTitle">Novo nome do arquivo</h5>
                    <button type="button" class="close simple-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formFileTitle">
                        @csrf

                        <input type="hidden" name="parent_id" value="{{ $category->id }}">
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" />
                        </div>

                        <div class="form-footer text-right">
                            <button type="submit" class="btn-submit-default">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('js')

@include('panel.scripts')

<script>
    const sendFile = ({
        target
    }) => {
        const file = target.files[0];
        if (file.type !== 'application/pdf') {
            alert('Por favor, selecione um arquivo PDF.');
            return;
        }
        target.closest('.upload-file').querySelector('.title-file').innerHTML = file.name;
    };

    document.addEventListener('DOMContentLoaded', () => {
        const select = document.getElementsByName('name');
        const modalElement = document.getElementById('titleFile');

        const nameForm = document.getElementById('formFileTitle');
        nameForm.addEventListener('submit', event => {
            event.preventDefault();
            const fileData = new FormData(nameForm);

            axios.post(`/panel/biddings/available-files/category/create`, fileData)
                .then(response => {
                    console.log(response, response.data);

                    const newOption = document.createElement('option');
                    newOption.value = response.data.category.id;
                    newOption.text = response.data.category.name;

                    select[0].appendChild(newOption);

                    // Define o novo option como selecionado
                    newOption.selected = true;

                    //close modal
                    modalElement.querySelector('.close').click();
                })
                .catch(error => console.log('erro ao tentar criar nome de arquivo'));

        });

    });
</script>

@endsection