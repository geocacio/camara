<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- @vite(['resources/sass/app.scss']) -->
    @vite(['resources/sass/panel.scss'])

</head>

<body>

    @extends('panel.flash-messages')

    <section class="dashboard">

        <div class="sidebar">
            <div class="container-toggle-menu">
                <a href="{{ route('home') }}" class="link" target="_blank">
                    <span class="title">lorem<span>IPSUM</span></span>
                </a>
            </div>
            @include('panel.menu')

        </div>

        <div class="content">
            <div class="header">
                <button class="btn-menu open" toggle-menu>
                    <span class="open"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg></span>
                </button>
                <div class="top">
                    <h3 class="title">Dashboard</h3>
                    <div class="user-menu">
                        <div class="dropdown dropleft">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ auth()->user()->name[0]}}
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                                <a class="dropdown-item logoff" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-power">
                                        <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
                                        <line x1="12" y1="2" x2="12" y2="12"></line>
                                    </svg>
                                    <span>{{ __('Logout') }}</span>
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="body no-pading-top">
                <h3 class="title-current-page">@yield('pageTitle')</h3>

                <ul class="breadcrumb">
                    @hasSection('breadcrumb')
                    @yield('breadcrumb')
                    @endif
                </ul>

                @yield('content')
            </div>
            <div class="footer">
                <span class="title">&copy; 2023 lorem<span>Ipsum</span></span>
            </div>
        </div>

    </section>

    @vite(['resources/js/app.js', 'resources/js/functions.js'])
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.tiny.cloud/1/qckzr4aamqewpv02mv3c86w9mwu3k0q9wt45xrz5ug3dnuxn/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>


    <script>
        var $j = jQuery.noConflict();
            $j(document).ready(function() {
            $j(".search-select").select2();
        });

        document.addEventListener('DOMContentLoaded', () => {
            //SideMenu
            const btnMenuCollaspse = document.querySelector('[toggle-menu]');
            const sidebar = document.querySelector('.sidebar');
            let closed = sidebar.offsetWidth == 54 ? true : false;
            const sidebarMenu = document.querySelector('.sidebar-menu');
            const spans = sidebarMenu.querySelectorAll('span');

            const itemActive = sidebarMenu.querySelector('.menu-item.active');
            if(itemActive){
            const collapseActive = itemActive.querySelectorAll('.collapse');
                if(!closed){
                    collapseActive.forEach(collapse => {
                        if (collapse.parentElement.classList.contains('active')) {
                            collapse.classList.add('show');
                        }
                    });
                }
            }

            btnMenuCollaspse.addEventListener('click', () => {
                if (!closed) {
                    closed = !closed;
                    sidebar.style.maxWidth = '54px';
                    sidebarMenu.querySelectorAll('.collapse.show').forEach(subMenu => subMenu.classList.remove('show'));
                    spans.forEach(span => {
                        span.style.display = 'none';
                    });
                    document.querySelector('.sidebar .container-toggle-menu .link').style.display = "none";
                } else {
                    closed = !closed;
                    sidebar.style.maxWidth = '250px';
                    spans.forEach(span => {
                        span.style.display = 'block';
                    });
                    document.querySelector('.sidebar .container-toggle-menu .link').style.display = "block";
                }
                sidebar.classList.toggle('closed');
                btnMenuCollaspse.classList.toggle('open');
            })

            sidebarMenu.addEventListener('mouseenter', () => {
                if (closed) {
                    sidebar.style.maxWidth = '250px';
                    spans.forEach(span => {
                        span.style.display = 'block';
                    });
                    document.querySelector('.sidebar .container-toggle-menu .link').style.display = "block";
                    sidebar.classList.toggle('closed');
                    btnMenuCollaspse.classList.toggle('open');
                }
            });

            sidebarMenu.addEventListener('mouseleave', () => {
                if (closed) {
                    sidebar.style.maxWidth = '54px';
                    spans.forEach(span => {
                        span.style.display = 'none';
                    });
                    sidebarMenu.querySelectorAll('.collapse.show').forEach(subMenu => subMenu.classList.remove('show'));
                    document.querySelector('.sidebar .container-toggle-menu .link').style.display = "none";
                    sidebar.classList.toggle('closed');
                    btnMenuCollaspse.classList.toggle('open');
                }
            });

            //Editor
            tinymce.init({
                selector: '.editor',
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                tinycomments_mode: 'embedded',
                tinycomments_author: 'Author name',
                mergetags_list: [{
                        value: 'First.Name',
                        title: 'First Name'
                    },
                    {
                        value: 'Email',
                        title: 'Email'
                    },
                ],
                images_upload_url: '{{ asset('/upload.php') }}',
            });
        });
    </script>
    @yield('js')
</body>

</html>