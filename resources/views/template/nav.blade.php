    <nav>
        <div class="logo">VELORA</div>
        <ul>
            @guest
                <li class="{{ Route::currentRouteName() == 'home' ? 'active' : '' }}">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="{{ Route::currentRouteName() == 'about' ? 'active' : '' }}">
                    <a href="{{ route('about') }}">About Us</a>
                </li>
                <li class="{{ Route::currentRouteName() == 'login' ? 'active' : '' }}">
                    <a href="{{ route('login') }}" class="login-btn">Login</a>
                </li>
            @endguest
            @auth
                <li class="{{ Route::currentRouteName() == 'home' ? 'active' : '' }}">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="{{ Route::currentRouteName() == 'scanning' ? 'active' : '' }}">
                    <a href="{{ route('scanning') }}">Scanning</a>
                </li>
                <li class="{{ Route::currentRouteName() == 'about' ? 'active' : '' }}">
                    <a href="{{ route('about') }}">About Us</a>
                </li>
                <li class="dropdown">
                    <button class="dropdown-button" id="profile-button">Profil</button>
                    <div class="dropdown-content" id="profile-menu">
                        <a href="{{ route('history') }}">
                            <svg viewBox="0 0 24 24">
                                <path
                                    d="M12 5.5A6.5 6.5 0 1 0 18.5 12 6.508 6.508 0 0 0 12 5.5zM12 15a9 9 0 0 1-8.66-6.11l-1.85 1.15A11.986 11.986 0 0 0 12 17a11.986 11.986 0 0 0 10.51-5.96l-1.85-1.15A9 9 0 0 1 12 15zm0 4a1 1 0 1 0 1 1 1 1 0 0 0-1-1z" />
                            </svg>
                            History
                        </a>
                        <a href="{{ route('logout') }}">
                            <svg viewBox="0 0 24 24">
                                <path d="M7 10v4h10v-4H7zm-4 8h18v2H3v-2zM3 4h18v2H3V4zm0 6h18v2H3v-2z" />
                            </svg>
                            Logout
                        </a>
                    </div>
                </li>
            @endauth
        </ul>
    </nav>


    <script>
        const profileBtn = document.getElementById('profile-button');
        const profileMenu = document.getElementById('profile-menu');
        const dropdownLi = profileBtn.parentElement;

        profileBtn.addEventListener('click', () => {
            dropdownLi.classList.toggle('show');
        });

        // Close dropdown if click outside
        window.addEventListener('click', e => {
            if (!dropdownLi.contains(e.target)) {
                dropdownLi.classList.remove('show');
            }
        });
    </script>
