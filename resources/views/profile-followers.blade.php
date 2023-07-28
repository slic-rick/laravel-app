<x-profile :sharedData="$sharedData" pageName="{{$sharedData['name']}}'s Followers">

  @include('profile-followers-only');

</x-profile>