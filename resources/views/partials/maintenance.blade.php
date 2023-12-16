<div class="modal show custom-backdrop modal-maintenance" style="display: block;" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            <div class="modal-body p-0">
                <div class="container-maintenance">
                    <div class="header">
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