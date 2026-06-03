
<nav class="navbar navbar-expand-lg border-bottom border-body" data-bs-theme="dark" style="background-color: #281C59;">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">{{ $title }}</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}"> <i class="fa-solid fa-house me-2"></i>Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('map') ? 'active' : '' }}" aria-current="page" href="{{ route('map') }}"> <i class="fa-solid fa-map-location-dot me-2"></i>Peta Interaktif</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('table') ? 'active' : '' }}" href="{{ route('table') }}"> <i class="fa-solid fa-table me-2"></i>Tabel</a>
        </li>

        @guest
        <li class="nav-item bg-primary rounded">
          <a class="nav-link text-white" href="{{ route('login') }}"> <i class="fa-solid fa-arrow-right-to-bracket me-2"></i>Login</a>
        </li>
        @endguest

        @auth
        <li class="nav-item  bg-danger rounded">
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-link text-white border-0 bg-transparent"> <i class="fa-solid fa-right-from-bracket me-2"></i>Logout</button>
            </form>
        </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
