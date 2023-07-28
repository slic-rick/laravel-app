<div class="list-group">
    @foreach ($followers as $follow)
    <a href="/profile/{{$follow->followersUsers->name}}" class="list-group-item list-group-item-action">
       <img class="avatar-tiny" src="/{{$follow->followersUsers -> avatar}}" />
       {{$follow->followersUsers->name}}
     </a>
    @endforeach
   
   </div>