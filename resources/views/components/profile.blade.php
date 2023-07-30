<x-layout pageName="Ericks blog">
    <div class="container py-md-5 container--narrow">
        <h2>
          <img class="avatar-small" src="avatar.png" /> Erick's Blog Posts
          @auth
          {{-- @if (auth() -> user() -> name === $sharedData['name']) --}}
          <a href="/manage-avatar" class="btn-secondary btn">Edit avatar</a>
          {{-- @endif --}}
          {{-- @if ($sharedData['isFollowing']) --}}
          {{-- <form class="ml-2 d-inline" action="/unfollow-user/{{$sharedData['name']}}" method="POST">
            @csrf
             <button class="btn btn-danger btn-sm">Stop Following <i class="fas fa-user-times"></i></button>
            @if (auth() -> user() -> name === $sharedData['name'])
            <a href="/manage-avatar" class="btn-secondary btn">Edit avatar</a>
            @endif
          </form>
          @endif --}}
          {{-- @if (!$sharedData['isFollowing'] AND auth() -> user() -> name  !=  $sharedData['name'] )
          <form class="ml-2 d-inline" action="/follow-user/{{$name}}" method="POST">
            @csrf
            <button class="btn btn-primary btn-sm">Follow <i class="fas fa-user-plus"></i></button>
            <!-- <button class="btn btn-danger btn-sm">Stop Following <i class="fas fa-user-times"></i></button> -->
          </form> 
          @endif
          --}}
          @endauth 

        </h2>
  
        <div class="profile-nav nav nav-tabs pt-2 mb-4">
          <a href="/web-dev" class="profile-nav-link nav-item nav-link {{Request::segment(0) == "" ? "active" : ""}}">Web Dev</a>
          <a href="/mobile-dev" class="profile-nav-link nav-item nav-link {{Request::segment(1) == "mobile-dev" ? "active" : ""}}"> Mobile Dev</a>
          <a href="/finance" class="profile-nav-link nav-item nav-link {{Request::segment(1) == "finance" ? "active" : ""}}">Finance</a>
          <a href="/ai" class="profile-nav-link nav-item nav-link {{Request::segment(1) == "ai" ? "active" : ""}}">Artificial Intelligence</a>
        </div>
  
        <div class=" profile-slot-content">
            {{$slot}}
        </div>
      </div>
</x-layout>