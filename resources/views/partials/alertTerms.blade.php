
<div class="card-terms" id="cardTerms" style="display: none;">
    <div class="terms-content">
        <span>
            O Portal do(a) Câmara Municipal de Cidelândia utiliza cookies para melhorar a sua experiência, de acordo com a nossa <a href="{{ route('term.index') }}">Política de Privacidade</a>, ao continuar navegando, você concorda com estas condições.
        </span>
        <div class="btns">
            <button id="btnConcordar" class="concordar">
                Concordo
            </button>
            <button id="btnNaoConcordo">
                Não concordo
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (!cookieExists('termos_aceitos')) {
            document.getElementById('cardTerms').style.display = 'block';
        }

        document.getElementById('btnConcordar').addEventListener('click', function () {
            aceitarTermos(true);
        });

        document.getElementById('btnNaoConcordo').addEventListener('click', function () {
            aceitarTermos(false);
        });

        function aceitarTermos(aceito) {
            document.cookie = "termos_aceitos=" + aceito;
            document.getElementById('cardTerms').style.display = 'none';

            document.cookie = "termos_aceitos=" + aceito;

            fetch("{{ route('termos.aceitar') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
                body: JSON.stringify({ aceito: aceito }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    console.log(data.message);
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => console.error('Erro:', error));
            
        }

        function cookieExists(name) {
            return document.cookie.split(';').some(cookie => {
                return cookie.trim().startsWith(name + '=');
            });
        }
    });
</script>