<x-layout pageName="{{$sharedData['name']}}">
    <div class="container py-md-5 container--narrow">
        <h2>
          <img class="avatar-small" src="/{{$sharedData['avatar']}}" /> {{$sharedData['name']}}
          @auth
          @if (auth() -> user() -> name === $sharedData['name'])
          <a href="/manage-avatar" class="btn-secondary btn">Edit avatar</a>
          @endif
          @if ($sharedData['isFollowing'])
          <form class="ml-2 d-inline" action="/unfollow-user/{{$sharedData['name']}}" method="POST">
            @csrf
             <button class="btn btn-danger btn-sm">Stop Following <i class="fas fa-user-times"></i></button>
            @if (auth() -> user() -> name === $sharedData['name'])
            <a href="/manage-avatar" class="btn-secondary btn">Edit avatar</a>
            @endif
          </form>
          @endif
          @if (!$sharedData['isFollowing'] AND auth() -> user() -> name  !=  $sharedData['name'] )
          <form class="ml-2 d-inline" action="/follow-user/{{$name}}" method="POST">
            @csrf
            <button class="btn btn-primary btn-sm">Follow <i class="fas fa-user-plus"></i></button>
            <!-- <button class="btn btn-danger btn-sm">Stop Following <i class="fas fa-user-times"></i></button> -->
          </form> 
          @endif
          @endauth
   
        </h2>
  
        <div class="profile-nav nav nav-tabs pt-2 mb-4">
          <a href="/profile/{{$sharedData['name']}}" class="profile-nav-link nav-item nav-link {{Request::segment(3) == "" ? "active" : ""}}">Posts: {{$sharedData['count']}}</a>
          <a href="/profile/{{$sharedData['name']}}/followers" class="profile-nav-link nav-item nav-link {{Request::segment(3) == "followers" ? "active" : ""}}"> Followers:{{$sharedData['followersCount']}}</a>
          <a href="/profile/{{$sharedData['name']}}/following" class="profile-nav-link nav-item nav-link {{Request::segment(3) == "following" ? "active" : ""}}">Following :{{$sharedData['followingCount']}}</a>
        </div>
  
        <div class=" profile-slot-content">
            {{$slot}}
        </div>



      </div>
</x-layout>