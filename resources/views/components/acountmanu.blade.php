<div class="account-menu">
    <div class="mobile-user-menu">
        <div class="mobile-user-menu-top js-mobile-account">
            <div class="mobile-user-menu-info">
                <div class="mobile-user-menu-avatar">
                    {{ auth()->user()->firstLatter() }}
                </div>
                <div class="mobile-user-menu-name" style="text-transform: capitalize">
                    {{ auth()->user()->name }}
                    <span> </span>
                </div>
            </div>
        </div>

    </div>

    <a href="{{ route('show.profile') }}"
        class="account-menu-item   @if (url()->current() == route('show.profile')) active-account-item @endif">
        <i class="icon-pckt-user"></i>
        Account Information
    </a>
    <a href="{{ route('show.orders') }}" class="account-menu-item @if (url()->current() == route('show.orders')) active-account-item @endif ">
        <i class="icon-pckt-orders"></i>
        Orders
    </a>

    <a href="{{ route('logout') }}"
        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"
        class="account-menu-item"><i class="icon-pckt-logout"></i>Logout</a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</div>
