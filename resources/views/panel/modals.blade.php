<div class="modal fade modal-preview-file" id="fileModal" tabindex="-1" role="dialog" aria-labelledby="fileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($files->count() > 0)
                    @if (pathinfo($files[0]->file->url, PATHINFO_EXTENSION) === 'pdf')
                    <embed src="{{ asset('storage/'.$files[0]->file->url) }}" width="100%" height="500px" type="application/pdf">
                    @elseif (in_array(pathinfo($files[0]->file->url, PATHINFO_EXTENSION), ['doc', 'docx']))
                    <iframe src="https://view.officeapps.live.com/op/view.aspx?src={{ urlencode(asset('storage/' .$files[0]->file->url)) }}" width="100%" height="500px"></iframe>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>