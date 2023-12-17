<div class="modal show custom-backdrop modal-maintenance" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="container-maintenance">
                    <div class="header">
                        <button type="button" class="circle-btn" data-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>

                        <i class="fa-solid fa-triangle-exclamation"></i>

                        <div class="info">
                            <h3 class="title">{{ $alert->title }}</h3>
                            <p class="text">{{ $alert->text }}</p>
                        </div>
                    </div>

                    <div class="body">

                        <div class="container-date-info">
                            <span class="date">{{ \Carbon\Carbon::parse($alert->start_date)->translatedFormat('j \de F \de Y') }}</span> - <span class="date">{{ \Carbon\Carbon::parse($alert->end_date)->translatedFormat('j \de F \de Y') }}</span>

                        </div>
                        <p class="description">{{ $alert->more_info }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .circle-btn {
        right: -15px;
        top: -15px;
        position: absolute;
        height: 30px;
        width: 30px;
        border: 2px solid #fff;
        border-radius: 30px;
        background: none;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;

    }
    .fa-xmark {
        font-size: 20px!important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
        modal.show();
    });

    document.querySelector('.circle-btn').addEventListener('click', function() {
        var modal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
        modal.hide();
    });
</script>