<tr id="rowID_{{ $user->id }}" class="rows @if($user->deleted_at) deleted @endif">
    <td class="id">
        {{ $user->id }}
    </td>
    <td class="title">
        <a href="{{ route('users.edit',['id' => $user->id])}}" class="name">{{ $user->name }}</a>
        <small class="d-block text-muted">
            @if(strlen($user->login))
                {{ $user->login . ' | ' }}
            @endif
            {{ $user->role_name }}
        </small>
        <small class="d-block text-muted">
            {!! $user->organization->name ?? '<span style="color: red">Имя организации не указано</span>' !!}
        </small>
    </td>
    <td class="status text-center">
        @if(!$user->is_blocked)
            <a href="" id="status_{{ $user->id }}" data-item-id="{{ $user->id }}" class="toggle-blocked-status"><i id="stat_{{ $user->id }}" class="fas fa-lock-open unblocked @if($user->deleted_at) disabled @endif"></i></a>
        @elseif($user->is_blocked)
            <a href="" id="status_{{ $user->id }}" data-item-id="{{ $user->id }}" class="toggle-blocked-status"><i id="stat_{{ $user->id }}" class="fas fa-lock blocked @if($user->deleted_at) disabled @endif"></i></a>
        @endif
    </td>
    <td class="actions text-center">
        @if($user->deleted_at)
            <a href="{{ route('users.restore', $user->id) }}" id="status_{{ $user->id }}" data-item-id="{{ $user->id }}" class="restore d-inline mr-2">
                <i id="stat_{{ $user->id }}" class="icon fas fa-trash-restore"></i>
            </a>
            <a href="{{ route('users.delete', $user->id) }}" data-item-id="{{ $user->id }}" class="delete d-inline">
                <i class="icon far fa-trash-alt"></i>
            </a>
        @else
            <a href="{{ route('users.edit', $user->id) }}" class="d-inline mr-2">
                <i class="icon fas fa-edit"></i>
            </a>
            <a href="{{ route('users.destroy', $user->id) }}" data-item-id="{{ $user->id }}" class="destroy d-inline">
                <i class="icon far fa-trash-alt"></i>
            </a>
        @endif
    </td>
</tr>
