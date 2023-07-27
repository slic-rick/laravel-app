<x-profile :sharedData="$sharedData">

    <div class="list-group">
      @foreach ($following as $follow)
      <a href="/profile/{{$follow->followingUsers->name}}" class="list-group-item list-group-item-action">
         <img class="avatar-tiny" src="/{{$follow->followingUsers-> avatar}}" />
       {{$follow->followingUsers->name}}
       </a>
      @endforeach
     
     </div>
  </x-profile>