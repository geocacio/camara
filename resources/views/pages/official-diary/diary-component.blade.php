@if(isset($single) && $single == true)
    <div class="col-md-3">
        <span class="last-edition">
            <div class="line-blue"></div>
            Última edição
        </span>
        <div class="box-dowload card main-card">
            <h6>DIÁRIO OFICIAL ELETRÔNICO</h6>
            <div class="circle">
                <i class="fa fa-file-contract"></i>
            </div>
            <span>VOL {{ $adjustedPosition }}/{{ $dayle->created_at->format('Y') }}</span>
            <span>{{ $dayle->created_at->format('d/m/Y') }}</span>

            <button class="dowload-journal">
                    <a href="{{ asset('storage/'.$dayle->files[0]->file->url) }}" target="_blank">
                        <i class="fa fa-download"></i>                        
                        Baixar
                    </a>
                </button>
            </div>
        </div>
    </div>

@elseif(isset($many) && $many == true)
    @if($dayles->count() > 0)
        @foreach ($dayles as $index => $dayle)
            @if($dayle->files->count() > 0)
                <div class="col-md-3">
                    <div class="box-dowload card main-card">
                        <h6>DIÁRIO OFICIAL ELETRÔNICO</h6>
                        <div class="circle">
                            <i class="fa fa-file-contract"></i>
                        </div>
                        <span>VOL {{ $index + 1 }}/{{ $dayle->created_at->format('Y') }}</span>
                        <span>{{ $dayle->created_at->format('d/m/Y') }}</span>
                        <button class="dowload-journal">
                            <a href="{{ asset('storage/'.$dayle->files[0]->file->url) }}" target="_blank">
                                <i class="fa fa-download"></i>                        
                                Baixar
                            </a>
                        </button>
                    </div>
                </div>
            @endif
            @endforeach
    @else
        <div class="col-md-3">
            <p><b>Nenhuma publicação ainda</b></p>
        </div>
    @endif
@endif

<style scoped>

    .col-md-3 {
        height: 300px;
    }
    
    .box-dowload {
        transition: all ease-out 0.6s;
        color: #30358c;
        align-items: center;
        gap: 2vh;
    }
    
    .box-dowload:hover {
        background-color: #30358c;
        cursor: pointer;
        color: white;
    }

    .box-dowload:hover h6 {
        color: white;
    }

    .box-dowload:hover .circle {
        background-color: white;
        color: #30358c;
    }

    .box-dowload h6 {
        color: #30358c;
        text-align: center;
    }

    .title-journal {
        color: #0000cd;
        font-size: 28px;
        padding-bottom: 20px;
        font-family: sans-serif;
        font-weight: bold;
    }

    .desc-journal {
        font-family: "Lato", sans-serif;
        color: #777;
    }

    .circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: #30358c;
        margin: 0 auto;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 34px;
        color: white;
    }

    .dowload-journal {
        /* display: none; */
        width: 100%;
        height: 40px;
        background-color: #191b3d;
        border: none;
        border-radius: 5px;
        margin-top: 20px;
    }

    .dowload-journal a {
        color: #fff;
    }


    .line-blue {
        width: 10px!important;
        height: 2px;
        background-color: #30358c;
    }

    .last-edition {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 13px;
        margin-bottom: 20px;
    }

    .box-expedient {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .title-expedient {
        color: #004080;
    }

    .content-expedient {
        font-size: 13px
    }
</style>