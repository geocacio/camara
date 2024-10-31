<div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportModalLabel">Exportar Dados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="doc_type">Selecione o formato:</label>
                <select id="doc_type" class="form-control">
                    <option value="">Selecione um formato</option>
                    <option value="xls">Excel (XLS)</option>
                    <option value="csv">CSV</option>
                    <option value="pdf">PDF</option>
                    <option value="json">JSON</option>
                    <option value="txt">Texto (TXT)</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="exportData()">Exportar</button>
            </div>
        </div>
    </div>
</div>

<script>
    async function exportData() {
        const format = document.getElementById('doc_type').value;

        if (!format) {
            alert('Por favor, selecione um formato.');
            return;
        }

        const params = new URLSearchParams();
        params.append('format', format);

        const route = '{{ $route }}';
        // Atualizar a URL da requisição para o endpoint correto
        const url = `${route}?${params.toString()}`;

        try {
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                const blob = await response.blob();
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');

                // Obter a data atual e formatá-la como "1-10"
                const today = new Date();
                const options = { day: 'numeric', month: 'numeric' };
                const formattedDate = today.toLocaleDateString('pt-BR', options).replace(/\//g, '-');

                // Definir o nome do arquivo
                a.href = url;
                a.download = `data-${formattedDate}.${format}`;
                document.body.appendChild(a);
                a.click();
                a.remove();
                
                // Fechar o modal após a exportação
                $('#exportModal').modal('hide');
            } else {
                const errorData = await response.json();
                alert(errorData.error || 'Erro ao exportar os dados.');
            }
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao fazer a requisição.');
        }
    }

    document.getElementById('doc_type').addEventListener('change', function() {
        if (this.selectedOptions.length > 1) {
            for (let i = 0; i < this.options.length; i++) {
                this.options[i].selected = false;
            }
            this.options[this.selectedIndex].selected = true;
        }
    });
</script>
