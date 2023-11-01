@extends('panel.index')

@section('pageTitle', 'Atualizar Departamento')
@section('breadcrumb')
<li><a href="{{ route('departments.index') }}">Departamentos</a></li>
<li><span>Atualizar Departamento</span></li>
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

        <form action="{{ route('departments.update', $department->slug) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="form-group">
                <label>Nome</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $department->name) }}" />
            </div>

            <div class="row">

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="title1">Selecione a Secretaria</label>
                        <select name="secretary_id" class="form-control" onchange="showOrgans(event, {{ $secretaries }})">
                            <option value="">Selecione</option>
                            @foreach($secretaries as $secretary)
                            <option value="{{$secretary->id}}" {{ $department->secretary && $department->secretary->id == $secretary->id ? 'selected' : ''}}>{{$secretary->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6" style="display: none;">
                    <div class="form-group">
                        <label for="title1">Selecione o orgão</label>
                        <select name="organ_id" class="form-control"></select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="title1">Selecione o Responsável</label>
                        <select name="employee_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($employees as $employee)
                            <option value="{{$employee->id}}" {{ $department->employee && $employee->id === $department->employee->employee_id ? 'selected' : '' }}>{{$employee->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Descrição</label>
                <textarea name="description" class="form-control">{{ old('description', $department->description) }}</textarea>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="addAddress" onchange="showAdditionalInformation(event)">
                <label class="form-check-label" for="addAddress">
                    Adicionar endereço
                </label>
            </div>

            <div class="additional-information" style="display: {{ $department->phone1 != '' || $department->phone2 != '' || $department->email != '' || $department->address || $department->zip_code != '' || $department->business_hours != '' ? 'block' : 'none' }};">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Telefone 1</label>
                            <input type="text" name="phone1" class="form-control mask-phone" value="{{ old('phone1', $department->phone1) }}" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Telefone 2</label>
                            <input type="text" name="phone2" class="form-control mask-phone" value="{{ old('phone2', $department->phone2) }}" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" value="{{ old('email', $department->email) }}" />
                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Endereço</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address', $department->address) }}" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>CEP</label>
                            <input type="text" name="zip_code" class="form-control mask-cep" value="{{ old('zip_code', $department->zip_code) }}" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Horário de atendimento</label>
                            <input type="text" name="business_hours" class="form-control" value="{{ old('business_hours', $department->business_hours) }}" />
                        </div>
                    </div>
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
    function showAdditionalInformation({
        target
    }) {
        console.log(target);
        if (target.checked) {
            document.querySelector('.additional-information').style.display = 'block';
        } else {
            document.querySelector('.additional-information').style.display = 'none';
        }
    }

    function showOrgans({target}, data) {
        const organs = target.value != '' ? data.find(secretary => target.value == secretary.id).organs : [];
        const organElement = document.querySelector('select[name="organ_id"]');
        
        if (organs.length > 0) {
            organElement.closest('.col-md-6').style.display = 'block';
            organElement.innerHTML = '';

            organs.forEach((organ, index) => {
                const newOption = document.createElement('option');
                newOption.value = organ.id;
                newOption.text = organ.name;

                organElement.appendChild(newOption);
            });
        }else{
            organElement.innerHTML = '<option value="">Selecione</option>';
            organElement.closest('.col-md-6').style.display = 'none';
        }

    }

    //Se tiver um orgão ele exibe
    document.addEventListener("DOMContentLoaded", () => {
        const secretaries = {!! json_encode($secretaries) !!};
        const selectSecretary = document.querySelector('select[name="secretary_id"]');

        if (selectSecretary.value !== '') {
            showOrgans({ target: selectSecretary }, secretaries);
        }
    });
</script>

@endsection