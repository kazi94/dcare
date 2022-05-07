<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
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
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">APPLICATIONS</li>
                <li>
                    <a href="{{ route('home.index') }}">
                        <i class="bg-primary icon-gradient metismenu-icon pe-7s-home"></i>
                        Acceuil
                    </a>
                </li>
                @canany(['isAdmin', 'isDentist'], Auth::user())
                    <li>
                        <a href="/mon-cabinet">
                            <i class="metismenu-icon pe-7s-graph2"></i>
                            Mon cabinet
                        </a>
                    </li>
                @endcanany
                <li>
                    <a href="/patients" class="___class_+?22___">
                        <i class="metismenu-icon icon-gradient bg-happy-itmeo pe-7s-id"></i>
                        Mes patients
                    </a>
                </li>
                <li>
                    <a href="/mes-honoraires" class="___class_+?24___">
                        <i class="metismenu-icon icon-gradient bg-grow-early pe-7s-cash"></i>
                        Mes honoraires
                    </a>
                </li>
                @canany(['isAdmin', 'isDentist'], Auth::user())
                    <li>
                        <a href="/mes-prescriptions" class="___class_+?26___">
                            <i class="metismenu-icon icon-gradient bg-happy-fisher pe-7s-note2"></i>
                            Mes ordonnances
                        </a>
                    </li>
                @endcanany
                <li>
                    <a href="{{ route('appointement.index') }}" class="___class_+?28___">
                        <i class="metismenu-icon icon-gradient bg-plum-plate pe-7s-date"></i>
                        Mon agenda
                    </a>
                </li>
                @can('isAdmin', Auth::user())
                    <li>
                        <a href="/admin/reglages" class="___class_+?30___">
                            <i class="metismenu-icon icon-gradient bg-mean-fruit font-weight-bold pe-7s-config"></i>
                            Réglages
                        </a>
                    </li>
                @endcan
                @canany(['isAdmin', 'isDentist'], Auth::user())
                    <li class="app-sidebar__heading">MEDIAS</li>
                    <li>
                        <a href="/mes-videos" class="___class_+?33___">
                            <i class="metismenu-icon icon-gradient bg-mean-fruit font-weight-bold pe-7s-video"></i>
                            Mes videos
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('bibliotheque.index') }}" class="___class_+?35___">
                            <i class="metismenu-icon icon-gradient bg-mean-fruit font-weight-bold pe-7s-photo"></i>
                            Mes photos
                        </a>
                    </li>
                @endcanany
            </ul>
        </div>
    </div>
</div>
