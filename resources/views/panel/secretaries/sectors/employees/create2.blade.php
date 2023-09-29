@extends('panel.index')

@section('pageTitle', 'Adicionar Funcionários')
@section('breadcrumb')
<li><a href="{{ route('sectors.index') }}">Setores</a></li>
<li><a href="{{ route('sectors.employees.index', $sector->slug) }}">Funcionários</a></li>
<li><span>Adicionar Funcionários</span></li>
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

        <form id="submitEmployee" action="{{ route('sectors.employees.store', $sector->slug) }}" method="post" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="sector_id" value="{{$sector->id}}">

            <div class="form-group">
                <label for="title1">Selecione os Funcionários</label>
                <div class="search-data">
                    <input type="text" name="search" class="form-control search" placeholder="Pesquisar">
                </div>
                <div class="container-checkbox">
                    @foreach($employees as $employee)
                    <div class="form-check">
                        <input class="form-check-input" id="employee_{{$employee->id}}" type="checkbox" name="employee_id[]" value="{{$employee->id}}" {{ in_array($employee->id, array_column($sector->employees->toArray(), 'employee_id')) ? 'checked' : ''}}>
                        <label class="form-check-label" for="employee_{{$employee->id}}">{{$employee->name}}</label>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="form-footer text-right">
                <button type="submit" class="btn-submit-default">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')

@include('panel.scripts')

<script>
    let containerList = document.querySelector('.container-checkbox');
    const search = document.querySelector('input[name="search"]');
    const checkboxes = document.querySelectorAll('.container-checkbox .form-check');
    let result = [];

    const normalizeText = (text) => {
        return text.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    };

    search.addEventListener('keyup', ({target}) => {
        const searchTerm = normalizeText(target.value);

        checkboxes.forEach( checkbox => {
            const label = checkbox.querySelector('.form-check-label');
            const labelText = normalizeText(label.textContent);

            if(!labelText.includes(searchTerm)){
                checkbox.style.display = 'none';
            }else{
                checkbox.style.display = 'block';
            }
        });

        result = Array.from(checkboxes).filter((checkbox) => {
            const label = checkbox.querySelector('.form-check-label');
            const labelText = normalizeText(label.textContent);

            return labelText.includes(searchTerm);
        });
        if(searchTerm != ''){
            if(result.length <= 0){
                const alertDiv = containerList.querySelector('.alert.alert-danger');
                if (alertDiv) {
                    alertDiv.remove();
                }
                
                const noResultDiv = document.createElement('div');
                noResultDiv.classList.add('alert', 'alert-danger');
                noResultDiv.textContent = 'Nenhum funcionário encontrado!';
                containerList.appendChild(noResultDiv);
                containerList.style.display = 'block';

            }else{
                containerList.style.display = 'grid';
                const alertDiv = containerList.querySelector('.alert.alert-danger');
                if (alertDiv) {
                    alertDiv.remove();
                }
            }
        }
    });
</script>

@endsection