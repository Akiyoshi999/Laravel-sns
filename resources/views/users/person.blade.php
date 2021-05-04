<div class="card mt-3">
  <div class="card-body">
    <div class="d-flex flex-row">
      <a href="{{ route('users.show', ['name' => $user->name]) }}" class="text-dark">
        <i class="fas fa-user-circle fa-3x"></i>
      </a>
      @if (Auth::id() !== $person->id)
        <follow-buttoon class="ml-auto" :inital-is-followerd-by='@json($person->isFollowedBy(Auth::user()))'
          :authorized='@json(Auth::check())' endpoint="{{ route('users.follow', ['name' => $person->name]) }}">
        </follow-buttoon>
      @endif
    </div>
    <h2 class="h5 card-title m-0">
      <a href="{{ route('users.show', ['name' => $person->name]) }}" class="text-dark">{{ $person->name }}</a>
    </h2>
  </div>
</div>
