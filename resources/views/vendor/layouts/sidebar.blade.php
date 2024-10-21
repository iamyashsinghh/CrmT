@php
$auth_user = Auth::user();
$uri_arr = explode(".", Route::currentRouteName());
$uri = end($uri_arr);
$route_name = Route::currentRouteName();
@endphp
<aside class="main-sidebar sidebar-dark-danger" style="background: var(--wb-dark-red);">
    <a href="{{route('vendor.dashboard')}}" class="brand-link text-center">
                <img src="{{asset('images/logo.png')}}" alt="AdminLTE Logo" style="width: 80% !important; filter: drop-shadow(1px 1px 5px #ffffff50);">

    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
            <div class="image">
                <a href="javascript:void(0);" onclick="handle_view_image('{{ $auth_user->profile_image ? asset('storage/'.$auth_user->profile_image) : asset('images/default-user.png') }}', '{{ route('updateProfileImage') }}/{{ $auth_user->id }}')">
                    <img src="{{ $auth_user->profile_image ? asset('storage/'.$auth_user->profile_image) : asset('images/default-user.png') }}"
                         onerror="this.onerror=null; this.src='{{ asset('images/default-user.png') }}'"
                         class="img-circle elevation-2"
                         alt="User Image"
                         style="width: 43px; height: 43px;">
                </a>
            </div>
            <div class="info text-center py-0">
                <a href="javascript:void(0);" class="d-block">{{$auth_user->f_name}} {{$auth_user->l_name ?: 'N/A'}} - {{$auth_user->get_role->name}}</a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('vendor.dashboard')}}" class="nav-link {{$uri == "dashboard" ? 'active' : ''}}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('vendor.case.index')}}" class="nav-link {{ strpos($route_name, 'cases') !== false ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-file"></i>
                        <p>Cases</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('vendor.wallets.index')}}" class="nav-link {{$uri == "wallets" ? 'active' : ''}}"  id="protectedLink">
                        <i class="nav-icon fas fa-wallet"></i>
                        <p>Wallet</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<script>

document.getElementById('protectedLink').addEventListener('click', function(e) {
    e.preventDefault();
    fetch("{{ route('check.vendor.password.session') }}", {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.access) {
            window.location.href = "{{ route('vendor.wallets.index') }}";
        } else {
            var password = prompt("Please enter the password to proceed:");

            if (password !== null) {
                fetch("{{ route('verify.vendor.wallets.index') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ password: password })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = "{{ route('vendor.wallets.index') }}";
                    } else {
                        alert("Incorrect password. Access denied.");
                    }
                });
            }
        }
    });
});




    $('.nav-sidebar').tree();
    function initialize_sidebar_collapse() {
        const sidebar_collapsible_elem = document.getElementById('sidebar_collapsible_elem');
        const localstorage_value = localStorage.getItem('sidebar_collapse');
        if (localstorage_value !== null) {
            if (localstorage_value == "true") {
                sidebar_collapsible_elem.setAttribute('data-collapse', 0);
                document.body.classList.add('sidebar-collapse');
            }
        }
    }
    initialize_sidebar_collapse();
</script>
