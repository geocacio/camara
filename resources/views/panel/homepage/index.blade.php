@extends('panel.index')
@section('pageTitle', 'Página home')

@section('content')

<div class="card">
    <div class="card-body">
        <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="service-tab" data-bs-toggle="tab" data-bs-target="#tabService" type="button" role="tab" aria-controls="tabService" aria-selected="true">Serviços</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Profile</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Contact</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="tabService" role="tabpanel" aria-labelledby="service-tab">
                <form id="submitService">
                    {{ csrf_field() }}
                    <div id="container-service" class="container-duplicated">
                        <div class="body no-padding">
                            @if($services && $services->count() > 0)
                            @foreach($services as $key => $service)
                            <div class="can-duplicated service-duplicated">
                                <div class="form-group">
                                    <label>Icon</label>
                                    <input type="text" name="icon_{{$key}}" class="form-control icon" value="{{ old('icon', $service->icon) }}">
                                </div>
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="title_{{$key}}" class="form-control title" value="{{ old('icon', $service->title) }}">
                                </div>
                                <div class="form-group">
                                    <label>Text</label>
                                    <input type="text" name="text_{{$key}}" class="form-control text" value="{{ old('icon', $service->text) }}">
                                </div>
                                <button class="btn-delete rounded" onclick="deleteItem(event, '/panel/service/{{$service->id}}')">
                                    <svg viewBox="0 0 24 24" style="fill: white; width: 20px; height: 20px;">
                                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" style="stroke-width: 4px;"></path>
                                    </svg>
                                </button>
                            </div>
                            @endforeach
                            @else
                            <div class="can-duplicated service-duplicated">
                                <div class="form-group">
                                    <label>Icon</label>
                                    <input type="text" name="icon" class="form-control icon" value="">
                                </div>
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control title" value="">
                                </div>
                                <div class="form-group">
                                    <label>Text</label>
                                    <input type="text" name="text" class="form-control text" value="">
                                </div>
                                <button class="btn-delete rounded" onclick="deleteItem(event)">
                                    <svg viewBox="0 0 24 24" style="fill: white; width: 20px; height: 20px;">
                                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" style="stroke-width: 4px;"></path>
                                    </svg>
                                </button>
                            </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <button class="btn-plus mt-3" onclick="moreOne(event, 'service-duplicated')">+</button>
                        </div>
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>

                </form>

            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    let checkboxVisibility = document.querySelector('input[name="visibility"]');

    function deleteItem(event, url = false) {
        event.preventDefault();
        event.stopPropagation();

        if (url) {
            axios.delete(url)
                .then(response => {
                    window.location.reload();
                })
                .catch(error => {
                    console.error(error);
                });

        }
    }

    function collectData(containerId, className, params, checkbox = null) {
        let container = document.getElementById(containerId).querySelector('.body');
        let items = container.querySelectorAll("." + className);

        let data = [];

        for (let i = 0; i < items.length; i++) {
            let obj = {};
            let checkboxValue = 0;

            if (checkbox) {
                let checkboxElement = items[i].querySelector("." + checkbox);
                if (checkboxElement && checkboxElement.checked) {
                    checkboxValue = 1;
                }
            }

            for (let j = 0; j < params.length; j++) {
                let inputName = '';
                let query = '';

                if (params[j] === 'image_choose') {
                    inputName = `${params[j]}_${i}`;
                    query = `input[name="${inputName}"]`;
                } else {
                    inputName = params[j];
                    query = `.${inputName}`;
                }

                let inputElement = items[i].querySelector(query);
                if (inputElement) {
                    if (params[j] === 'image_choose') {
                        obj[inputName] = inputElement.files[0];
                    } else {
                        if (inputElement.classList.contains('editor')) {
                            obj[inputName] = CKEDITOR.instances[inputElement.name].getData();
                        } else {
                            obj[params[j]] = inputElement.value;
                        }
                    }
                }
            }

            if (checkbox) {
                obj[checkbox] = checkboxValue;
            }

            data.push(obj);
        }

        return data;
    }

    function moreOne(event, className) {
        event.preventDefault();
        let container = event.target.closest('.container-duplicated').querySelector('.body');
        let duplicatedItem = container.querySelector('.' + className);
        let newItem = duplicatedItem.cloneNode(true);

        let inputs = newItem.getElementsByTagName("input");

        for (let i = 0; i < inputs.length; i++) {
            inputs[i].name = inputs[i].name + "_" + (container.childElementCount);
            inputs[i].value = '';
        }

        newItem.querySelector('.btn-delete').onclick = function(e) {
            e.stopPropagation();
            e.preventDefault();
            e.target.closest("." + className).remove();
        };

        container.appendChild(newItem);
    }

    document.getElementById("submitService").addEventListener("submit", function(event) {
        event.preventDefault();

        // let csrf_token = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
        let csrf_token = document.querySelector('input[name="_token"]').getAttribute("value");
        let formData = new FormData(this);
        let form = document.getElementById("submitService");

        let serviceDataParams = ["icon", "title", "text"];
        let serviceData = collectData("container-service", "service-duplicated", serviceDataParams);
        formData.append('services_tab', JSON.stringify(serviceData));

        axios.post('/panel/service', formData, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrf_token,
                "Content-Type": "multipart/form-data",
                'Accept': 'application/json'
            }
        }).then(response => {
            localStorage.setItem('successMessage', response.data.success);
            location.reload();
            // Após a atualização da página
            if (localStorage.getItem('successMessage')) {
                localStorage.removeItem('successMessage');
            }
        })
        .catch( error => console.log(error));
    });
</script>
@endsection