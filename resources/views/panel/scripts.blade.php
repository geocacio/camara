<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
    //mascaras...
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
        $('.mask-phone').mask('(00) 9 0000-0000');
        $('.mask-cep').mask('00000-000');
        $('.mask-cpf').mask('000.000.000-00');
    });

    function showTempFile({
        target
    }, mainContent, container) {
        const file = target.files[0];
        const myContainer = target.closest('.' + mainContent).querySelector('.' + container);
        const removeButton = Object.assign(document.createElement('button'), {
            type: 'button',
            className: 'btn-delete'
        });
        removeButton.innerHTML = `<svg viewBox="0 0 24 24" style="fill: white; width: 20px; height: 20px;">
        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" style="stroke-width: 4px;"></path>
        </svg>`;
        removeButton.addEventListener('click', function(e) {
            const img = myContainer.querySelector('img');
            const video = myContainer.querySelector('video');
            if (img) {
                img.remove()
            }
            if (video) {
                video.remove()
            }
            removeButton.remove();
            target.value = '';
        });

        if (target.accept) {
            if (target.accept.includes('video')) {
                const video = myContainer.querySelector('video');
                if (file.type.includes('video')) {
                    if (video) {
                        video.remove()
                    }
                    const videoElement = document.createElement('video');
                    videoElement.src = URL.createObjectURL(file);
                    videoElement.loop = true;
                    videoElement.muted = true;
                    videoElement.autoplay = true;
                    myContainer.appendChild(videoElement);
                } else {
                    target.value = '';
                }
            } else if (target.accept.includes('image')) {
                const img = myContainer.querySelector('img');
                if (file.type.includes('image')) {
                    if (img) {
                        img.remove()
                    }
                    const imageElement = document.createElement('img');
                    imageElement.src = URL.createObjectURL(file);
                    myContainer.appendChild(imageElement);
                } else {
                    target.value = '';
                }


            }
            myContainer.appendChild(removeButton);
        }
    }

    function removeFile(e, container, url = false) {
        e.preventDefault();
        const mainContainer = e.target.closest('.' + container);
        mainContainer.querySelector('.image').remove();
        mainContainer.querySelector('.btn-delete').remove();

        axios.delete(url)
            .then(response => {
                console.log(response.data.message)
                if (checkIfRunningInterval()) {
                    stopProgress();
                }
                const toast = document.querySelector('.toast');
                toast.querySelector('.message').innerHTML = response.data.message;

                startProgress();
            })
            .catch(error => {
                // Tratar erros da requisição (opcional)
                console.error('Erro ao deletar a imagem:', error);
            });
    }

    function displayTempImages(e, container) {
        var file = e.target.files[0];

        // Verificar se é um arquivo de imagem
        if (file && file.type.startsWith('image/')) {
            var reader = new FileReader();
            var img = document.querySelector('.' + container).querySelector('.image');
            var previewElement = document.querySelector('.' + container);

            previewElement.classList.remove('hide');

            reader.onload = function(e) {
                img.src = e.target.result;
            };

            reader.readAsDataURL(file);
        }
    }

    function toggleFile({
        target
    }) {
        const inputFile = target.closest('.form-group').querySelector('input[type="file"]').click();
    }

    function deleteFile(e, container, url = false) {
        e.preventDefault();

        var isImage = false;

        // Verificar se é um link
        var fileLink = document.querySelector('.' + container).querySelector('.btn-link');
        if (fileLink) {
            var fileName = fileLink.innerText.trim();
            var fileExtension = fileName.substr(fileName.lastIndexOf('.') + 1).toLowerCase();

            // Verificar se é uma imagem
            if (fileExtension === 'jpg' || fileExtension === 'jpeg' || fileExtension === 'png' || fileExtension === 'gif') {
                // É uma imagem, faça o processamento adequado aqui
                var img = document.querySelector('.' + container).querySelector('.image');
                img.src = '';
                isImage = true;
            }
        }

        // Verificar se é um botão
        var deleteButton = document.querySelector('.' + container).querySelector('.btn-delete');
        if (deleteButton) {
            var fileType = deleteButton.getAttribute('data-file-type');

            // Verificar o tipo de arquivo no caso de ser um botão
            if (fileType === 'image' && !isImage) {
                // Não é uma imagem, faça o processamento adequado aqui
                return;
            }
        }

        e.target.closest('.' + container).classList.add('hide');

        // Limpar o valor do campo files
        var input = e.target.closest('.form-group').querySelector('input[type="file"]');
        input.value = '';
        if (url) {

            var element = e.target.closest('.' + container).closest('.form-group').querySelector('input[type="file"]');
            var display = window.getComputedStyle(element).getPropertyValue('display');
            if (display === 'none') {
                element.style.display = 'block';
            }


            axios.delete(url)
                .then(response => {
                    console.log(response.data.message)
                    if (checkIfRunningInterval()) {
                        stopProgress();
                    }
                    const toast = document.querySelector('.toast');
                    toast.querySelector('.message').innerHTML = response.data.message;

                    startProgress();
                })
                .catch(error => {
                    // Tratar erros da requisição (opcional)
                    console.error('Erro ao deletar a imagem:', error);
                });
        }
    }
    let hideMessage;

    function startProgress() {
        const toast = document.querySelector('.toast');
        toast.classList.add('show', 'success');
        const progress = document.querySelector('.progress-close');
        progress.style.width = `0%`;

        let width = 0;
        hideMessage = setInterval(() => {
            width++;
            progress.style.width = `${width}%`;
            if (width >= 100) {
                toast.classList.remove('show', 'success');
                clearInterval(hideMessage);
                hideMessage = null;
            }
        }, 30);
    }

    function checkIfRunningInterval() {
        return hideMessage;
    }

    function stopProgress() {
        clearInterval(hideMessage);
    }

    function showVideoSource({
        target
    }) {
        if (target.value != "internal") {
            document.querySelector('.source-external').style.display = 'block';
            document.querySelector('.source-internal').style.display = 'none';
        } else {
            document.querySelector('.source-internal').style.display = 'block';
            document.querySelector('.source-external').style.display = 'none';
        }
        if (!target.value) {
            document.querySelector('.source-internal').style.display = 'none';
            document.querySelector('.source-external').style.display = 'none';
        }
    }

    //Show icon list on modal
    document.addEventListener('DOMContentLoaded', () => {
        const getModal = document.getElementById('modalIconList');
        if (getModal) {
            const lists = getModal.querySelectorAll('.list-icons li');
            const btnClose = getModal.querySelector('.close');

            lists.forEach(li => {
                li.addEventListener('click', ({
                    target
                }) => {
                    const inputName = document.getElementById('modalIconList').getAttribute('inputName');
                    const currentInput = document.querySelector('input[name="' + inputName + '"]');
                    currentInput.value = target.querySelector('i').className;
                    btnClose.click();
                })
            });
        }
    })

    function getIconInputValues({
        target
    }) {
        const getModal = document.getElementById('modalIconList');
        getModal.setAttribute('inputName', target.getAttribute('name'))
        let modal = new bootstrap.Modal(getModal);
        modal.show();
    }

    function splitAndDisplayMoreColumn(e, parentElementSelector) {
        console.log(e.target.value)
        const parentElement = document.querySelector(parentElementSelector);
        const cols = parentElement.querySelectorAll('[class^="col-"]');
        if(e.target.value == 'yes'){
            cols[0].classList.remove('col-md-6');
            cols[0].classList.add('col-md-12');
            cols[1].classList.add('d-none');
        }else{
            cols[1].classList.remove('d-none');
            cols[0].classList.add('col-md-6');
            cols[0].classList.remove('col-md-12');
        }
        console.log(cols[0])
    }

    //split and display more column
    // function splitAndDisplayMoreColumn(parentElement) {
    //     const row = document.querySelectorAll(`parentElement`);
    //     const cols = row.querySelectorAll('[class^="col-"]');
    //     console.log(cols)
    //     // cols.forEach( col => {
    //     //     console.log(col)
    //     // });
    // }
</script>