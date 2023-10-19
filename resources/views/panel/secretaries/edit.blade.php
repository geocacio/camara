@extends('panel.index')

@section('pageTitle', 'Informações da Câmara')
@section('breadcrumb')
<li><a href="{{ route('secretaries.index') }}">Câmara</a></li>
<li><span>Informações da Câmara</span></li>
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('secretaries.update', $secretary->slug) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $secretary->name) }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Plenário</label>
                        <input type="text" name="plenary" class="form-control" value="{{ old('plenary', $secretary->plenary) }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>CNPJ</label>
                        <input type="text" name="cnpj" class="form-control mask-cnpj" value="{{ old('cnpj', $secretary->cnpj) }}" />
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Telefone 1</label>
                        <input type="text" name="phone1" class="form-control mask-phone" value="{{ old('phone1', $secretary->phone1) }}" />
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Telefone 2</label>
                        <input type="text" name="phone2" class="form-control mask-phone" value="{{ old('phone2', $secretary->phone2) }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" class="form-control" value="{{ old('email', $secretary->email) }}" />
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Endereço</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address', $secretary->address) }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>CEP</label>
                        <input type="text" name="zip_code" class="form-control mask-cep" value="{{ old('zip_code', $secretary->zip_code) }}" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Horário de atendimento</label>
                        <input type="text" name="business_hours" class="form-control" value="{{ old('business_hours', $secretary->business_hours) }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Descrição</label>
                        <textarea name="description" class="form-control">{{ old('description', $secretary->description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="custom-input-file">
                    <label for="logo">Imagem da Secretaria</label>
                    <input type="file" name="file" accept="image/*" class="form-control" onchange="showTempFile(event, 'custom-input-file', 'container-temp-file')">
                    <div class="container-temp-file">
                        @if($secretary->files->count() > 0)
                        <img class="image" src="{{ asset('storage/'.$secretary->files[0]->file->url) }}" />
                        <button class="btn-delete" onclick="removeFile(event, 'container-temp-file', '/panel/files/{{$secretary->files[0]->file->id}}')">
                            <svg viewBox="0 0 24 24" style="fill: white; width: 20px; height: 20px;">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" style="stroke-width: 4px;"></path>
                            </svg>
                        </button>
                        @endif
                        <button type="button" class="btn btn-toggle-file" onclick="toggleFile(event)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="form-footer text-right">
                <button type="submit" class="btn-submit-default">Guardar</button>
            </div>
        </form>
    </div>

    <div class="modal fade modal-lg" id="responsibleFormModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center" id="exampleModalLongTitle">Novo Responsável</h5>
                    <button type="button" class="close simple-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formResponsible">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nome</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title1">Selecione o cargo</label>
                                    <select name="office_id" class="form-control">
                                        <option value="">Selecione</option>
                                        @foreach($offices as $office)
                                        <option value="{{$office->id}}">{{$office->office}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>E-mail</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Telefone</label>
                                    <input type="text" name="phone" class="form-control mask-phone" value="{{ old('phone') }}" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>CPF</label>
                                    <input type="text" name="cpf" class="form-control mask-cpf" value="{{ old('cpf') }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Dependentes</label>
                                    <input type="number" name="dependents" class="form-control" value="{{ old('dependents') }}" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Data de admissão</label>
                                    <input type="date" name="admission_date" class="form-control" value="{{ old('admission_date') }}" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title1">Tipo de emprego</label>
                                    <select name="employment_type" class="form-control">
                                        <option value="Permanent">Efetivo</option>
                                        <option value="Temporary">Temporario</option>
                                        <option value="Contractor">Terceirizado</option>
                                        <option value="Intern">Estagiário</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title1">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="Active">Ativo</option>
                                        <option value="Inactive">Inativo</option>
                                        <option value="Suspended">Suspenso</option>
                                        <option value="On Leave">Em licença</option>
                                        <option value="Terminated">Demitido</option>
                                        <option value="Retired">Aposentado</option>
                                        <option value="Transferred">Transferido</option>
                                        <option value="In Training">Em treinamento</option>
                                        <option value="Hiring Process">Em processo de contratação</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Senha</label>
                                    <input type="password" name="password" class="form-control" value="{{ old('password') }}" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Confirmar Senha</label>
                                    <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-input-file">
                                <label for="logo">Imagem do Funcionário</label>
                                <input type="file" name="file" accept="image/*" class="form-control" onchange="showTempFile(event, 'custom-input-file', 'container-temp-file')">
                                <div class="container-temp-file">
                                    <button type="button" class="btn btn-toggle-file" onclick="toggleFile(event)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>

<script>
    $(document).ready(function() {
        $('.mask-currency').maskMoney({
            prefix: 'R$ ',
            thousands: '.',
            decimal: ',',
            precision: 2
        });
        $('.mask-quantity').maskMoney({
            precision: 2,
            thousands: '',
            decimal: '.'
        });
        $('.mask-cnpj').mask('00.000.000/0000-00');
        $('.mask-phone').mask('(00) 0000-0000');
        $('.mask-cep').mask('00000-000');
    });
</script>

@include('panel.scripts')

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const responsible = document.getElementsByName('employee_id');
        const modalElement = document.getElementById('responsibleFormModal');

        const responsibleForm = document.getElementById('formResponsible');
        responsibleForm.addEventListener('submit', event => {
            event.preventDefault();
            const responsibleData = new FormData(responsibleForm);

            axios.post('/panel/secretaries/responsible/create', responsibleData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(response => {
                    console.log(response, response.data);

                    const newOption = document.createElement('option');
                    newOption.value = response.data.employee.id;
                    newOption.text = response.data.employee.name;

                    responsible[0].appendChild(newOption);

                    // Define o novo option como selecionado
                    newOption.selected = true;

                    //close modal
                    modalElement.querySelector('.close').click();
                })
                .catch(error => console.log('erro ao tentar criar nova licitação'));

        });

    });
</script>

@endsection