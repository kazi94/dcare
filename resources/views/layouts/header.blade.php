        <div class="app-header header-shadow">
            <div class="app-header__logo">
                <div class="logo-src"></div>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic is-active"
                            data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu">
                <span>
                    <button type="button"
                        class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
            </div>
            <div class="app-header__content">
                @yield('header')
                <!-- <div class="app-header-left">
                    <div class="search-wrapper">
                        <div class="input-holder">
                            <input type="text" class="search-input" placeholder="Type to search">
                            <button class="search-icon"><span></span></button>
                        </div>
                        <button class="close"></button>
                    </div>
                </div> -->
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="btn-group">
                                        <a data-toggle="dropdown" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                            aria-expanded="false" class="p-0 btn">
                                            {{-- <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}+{{ Auth::user()->prenom }}"
                                                alt="..." width="42" class="rounded-circle"> --}}
                                            <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                        </a>
                                        <div aria-labelledby="dropdownMenuButton1"
                                            class="dropdown-menu dropdown-menu-right">
                                            {{-- <button type="button" tabindex="0" class="dropdown-item">User Account</button> --}}
                                            <button type="button" tabindex="0" class="dropdown-item"
                                                onclick="location.href='/admin/reglages'">Paramètres</button>
                                            <div tabindex="-1" class="dropdown-divider"></div>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                            <button type="button" tabindex="0" class="dropdown-item" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">Déconnexion</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content-left  ml-3 header-user-info">
                                    <div class="widget-heading">
                                        Dr. {{ strtoupper(Auth::user()->name) }}
                                        {{ strtoupper(Auth::user()->prenom) }}
                                    </div>
                                    <div class="widget-subheading">
                                        {{ Auth::user()->profession }}
                                    </div>
                                </div>
                                {{-- <div class="widget-content-right header-user-info ml-3">
                                    <button type="button"
                                        class="btn-shadow p-1 btn btn-primary btn-sm show-toastr-example">
                                        <i class="fa text-white fa-calendar pr-1 pl-1"></i>
                                    </button>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
