<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{url('/')}}">Study+</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <!-- <a class="nav-link active" aria-current="page" href="{{url('/')}}">Home</a> -->
          </li>
          @auth
            <li class="nav-item">
              <a class="nav-link" href="{{url('/dashboard')}}">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('/discussionBoard')}}">Discussion Board</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('/timer')}}">Study Timer</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('/chat')}}">Chat</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('/map')}}">Map</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('/logout')}}">Logout</a>
            </li>
          @else
            <li class="nav-item">
              <a class="nav-link" href="{{url('/login')}}">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('/register')}}">Register</a>
            </li>
          @endauth
        </ul>
      </div>
    </div>
</nav>
