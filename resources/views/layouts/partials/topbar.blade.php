<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-4">
    <div class="container-fluid">

        {{-- LEFT SIDE --}}
        <span class="navbar-brand mb-0 h6">
            @yield('page-title', 'Master Data')
        </span>

        {{-- RIGHT SIDE --}}
        <div class="d-flex align-items-center ms-auto">

            @auth
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                        {{ auth()->user()->name }}
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li class="dropdown-item-text small text-muted">
                            {{ auth()->user()->email }}
                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="dropdown-item text-danger">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth

        </div>
    </div>
</nav>
