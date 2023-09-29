@extends('panel.index')
@section('pageTitle', 'Ordem das seções')

@section('breadcrumb')
<li><a href="{{ route('pages.index') }}">Pages</a></li>
<li><span>Posições</span></li>
@endsection

@section('content')

<div class="card">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="card-header bg-white no-border-bottom">
        <div class="form-footer bg-white text-right no-padding">
            <button onclick="submitPosition('/panel/configurations/pages/{{$page->slug}}')" class="btn-submit-default">Guardar</button>
        </div>
    </div>
    <div class="card-body">
        @if($page)
        <div class="drag-and-drop">
            @foreach($page->sections as $ind => $section)
            <div class="dad-card" draggable="true" data-id="{{$section->id}}"><span class="number-position">{{ $section->position }}</span> <span class="name">{{ $section->name }}</span></div>
            @endforeach
        </div>
        @else
        <div>Não existe nenhuma sessão para esta página</div>
        @endif
    </div>
    <div class="card-footer text-right bg-white no-margin">
        <div class="form-footer bg-white no-padding">
            <button onclick="submitPosition('/panel/configurations/pages/{{$page->slug}}')" class="btn-submit-default">Guardar</button>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        let changedPosition = false;
        document.addEventListener('dragstart', e => {
            e.target.classList.add('is-dragging');
            elementBeingDragged = e;
            e.target.style.opacity = '0.5';
        });

        document.addEventListener('dragend', ({
            target
        }) => {
            target.classList.remove('is-dragging');
            target.style.opacity = '1';
            if (changedPosition) {
                updateNumberPositions();
                changedPosition = false;
            }
        });

        let mainDAD = document.querySelectorAll('.dad-card');

        mainDAD.forEach(card => {
            card.addEventListener('dragover', e => {
                let fatherDAD = elementBeingDragged.target.closest('.drag-and-drop');
                let move = newPosition(fatherDAD, e.clientY)

                if (move) {
                    move.insertAdjacentElement('afterend', elementBeingDragged.target);
                    changedPosition = true;
                } else {
                    fatherDAD.prepend(elementBeingDragged.target);
                }
            });
        });

        function newPosition(boxes, positionY) {
            let brothersBox = boxes.querySelectorAll('.dad-card:not(.is-dragging)');
            let result;

            for (let card_item of brothersBox) {
                const currentCard = card_item.getBoundingClientRect();

                const currentCardCenterY = currentCard.y + currentCard.height / 2;
                if (positionY >= currentCardCenterY) result = card_item;
            }
            return result;
        }
    });


    function updateNumberPositions() {
        const container = document.querySelector('.drag-and-drop');
        let cards = container.querySelectorAll('.dad-card');
        let index = 1;
        cards.forEach(card => {
            let numberPosition = card.querySelector('.number-position');
            animateElement(numberPosition);
            setTimeout(() => {
                numberPosition.style.transform = 'rotateY(-180deg)';
            }, 500);
            setTimeout(() => {
                numberPosition.textContent = index;
                numberPosition.style.transform = 'rotateY(0)';
                index++;
            }, 1000);
        });
    }

    function animateElement(element) {
        element.classList.add('horizontal-turning');
        element.classList.remove('horizontal-turning');
    }

    function submitPosition(url) {
        const container = document.querySelector('.drag-and-drop');
        let cards = container.querySelectorAll('.dad-card');

        let positions = [];
        cards.forEach((card, index) => {
            let sectionId = card.dataset.id;
            positions.push({
                sectionId: sectionId,
                position: index + 1
            });
        });

        let requestData = {
            positions: positions
        };

        const csrf_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        axios.post(url, requestData, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrf_token,
                    "Content-Type": "multipart/form-data",
                    'Accept': 'application/json'
                },
                params: {
                    _method: 'PUT'
                }
            }).then(response => {
                localStorage.setItem('successMessage', response.data.success);
                location.reload();
                // Após a atualização da página
                if (localStorage.getItem('successMessage')) {
                    localStorage.removeItem('successMessage');
                }
            })
            .catch(error => console.log(error));
    }
</script>
@endsection