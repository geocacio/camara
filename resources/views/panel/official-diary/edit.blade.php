@extends('panel.index')
@section('pageTitle', 'Diário Oficial')
@section('breadcrumb')
<li><a href="{{ route('official-diary.index') }}">Diários</a></li>
<li><span>novo Diário</span></li>
@endsection
@section('content')
<div class="card">
    <div class="card-body fullscreen">
        <button class="btn-fullscreen" title="Tela cheia" onclick="toggleFullscreen()"><i class="fa-solid fa-expand"></i></button>
        <div class="row">
            <div class="col-md-4">
                @if($requestSecretaries)
                <div class="publications-list">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($requestSecretaries as $request)
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-modal" data-toggle="modal" data-target="#publication-{{ $request->id }}">
                                            {{ $request->title }}
                                        </button>
                                        <div class="modal fade" id="publication-{{ $request->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">{{ $request->title }}</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        {!! $request->content !!}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="actions text-right">
                                        <div class="form-group">
                                            <div class="toggle-switch">
                                                <input type="checkbox" id="toggle-{{ $request->id }}" name="visibility-{{ $request->id }}" value="" class="toggle-input" onchange="getDataToEditor(event, 'publication-{{ $request->id }}')">
                                                <label for="toggle-{{ $request->id }}" class="toggle-label"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>



                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                <div class="no-data">
                    <span>Ainda não existem Solicitações para o diário oficial!</span>
                </div>
                @endif
            </div>
            <div class="col-md-8">
                <!-- <form id="formOfficialDiary" action="{{ route('official-diary.store') }}" method="post" enctype="multipart/form-data"> -->
                <form id="formOfficialDiary">
                    @csrf
                    <input type="hidden" name="officialJournal_id" value="{{ $official_diary->id }}">
                    <input type="hidden" name="status" value="publicado">
                    <div class="form-group">
                        <label>Conteúdo</label>
                        <textarea id="editor-official-diary" name="content">{{ old('content', $official_diary->content) }}</textarea>
                    </div>

                    <div class="form-footer text-right">
                        <button type="submit" class="btn-submit-default">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

<script>
    let contentEditor = '';
    let contentOrder = [];

    function toggleFullscreen() {
        var fullscreenDiv = document.querySelector('.fullscreen');
        if (!document.fullscreenElement) {
            if (fullscreenDiv.requestFullscreen) {
                fullscreenDiv.requestFullscreen();
            } else if (fullscreenDiv.mozRequestFullScreen) {
                fullscreenDiv.mozRequestFullScreen();
            } else if (fullscreenDiv.webkitRequestFullscreen) {
                fullscreenDiv.webkitRequestFullscreen();
            } else if (fullscreenDiv.msRequestFullscreen) {
                fullscreenDiv.msRequestFullscreen();
            }
            fullscreenDiv.querySelector('.row').style.height = '100%';
            document.querySelector('.tox.tox-tinymce').style.height = 'calc(100vh - 170px)';
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            }
            fullscreenDiv.querySelector('.row').style.height = 'inherit';
            document.querySelector('.tox.tox-tinymce').style.height = '400px';
        }
    }

    tinymce.init({
        selector: '#editor-official-diary',
        setup: function(editor) {
            editorInstance = editor; // Armazena a instância do editor na variável global
        },
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        mergetags_list: [{
                value: 'First.Name',
                title: 'First Name'
            },
            {
                value: 'Email',
                title: 'Email'
            },
        ],
        images_upload_url: '/upload.php',
    });
    //está sendo usado na página de criação do diário oficial
    function getDataToEditor(e, modalContent) {
        const title = e.target.closest('tr').querySelector('.btn.btn-modal').innerHTML.trim();
        
        if (e.target.checked) {
            let content = '';
            content += '<h1 class="summary">' + title + '</h1>\n\n' + document.querySelector('#' + modalContent + ' .modal-body').innerHTML;
            contentOrder.push({
                'modal': modalContent,
                'position': contentOrder.length + 1,
                'content': content
            });
            addToEditor();
        } else {
            contentOrder = contentOrder.filter(function(item) {
                return item.modal !== modalContent;
            });
            addToEditor();
        }
    }

    function addToEditor() {
        let data = contentOrder;
        editorInstance.setContent('');

        if (data.length > 0) {

            data.sort(function(a, b) {
                return a.position - b.position;
            });

            var contentEditor = data.map(function(item) {
                return item.content;
            }).join("");
        } else {
            contentEditor = '';
        }

        editorInstance.setContent(editorInstance.getContent() + contentEditor);
    }

    document.getElementById('formOfficialDiary').addEventListener('submit', e => {
        e.preventDefault();
        
        let publication_ids = [];
        contentOrder.forEach(item => {
            const id = item.modal.split('-')[1];
            publication_ids.push(id);
        });

        const formData = new FormData(e.target);
        formData.set('content', tinymce.get('editor-official-diary').getContent());
        formData.set('publication_ids', JSON.stringify(publication_ids));
        formData.set('_method', 'PUT');

        const id = document.querySelector('[name="officialJournal_id"]').value;
        axios.post(`/panel/official-diary/${id}`, formData)
        .then(response => {
            window.location.href = '/panel/official-diary';
        })
        .catch(error => {
            console.error(error);
        });

    });
</script>

@endsection