<tr id="rowID_{{ $u->id }}" class="rows @if($u->deleted_at) deleted @endif">
    <td class="id">
        {{ $u->id }}
    </td>
    <td class="title">
        <a href="{{ route('dashboard.users.edit', $u->id) }}" class="name">{{ $u->name }}</a>
        <small class="d-block text-muted">
            @if(strlen($u->login))
                {{ $u->login . ' | ' }}
            @endif
            {{ $u->role_name }}
        </small>
        <small class="d-block text-muted">
            {!! $u->organization->name ?? '<span style="color: red">Имя организации не указано</span>' !!}
        </small>
    </td>
    <td class="status text-center">
        @if(!$u->is_blocked)
            <a href="{{ route('dashboard.users.toggle-blocked-status', $u->id) }}" id="status_{{ $u->id }}" data-item-id="{{ $u->id }}" class="toggle-blocked-status"><i id="stat_{{ $u->id }}" class="fas fa-lock-open unblocked @if($u->deleted_at) disabled @endif"></i></a>
        @elseif($u->is_blocked)
            <a href="{{ route('dashboard.users.toggle-blocked-status', $u->id) }}" id="status_{{ $u->id }}" data-item-id="{{ $u->id }}" class="toggle-blocked-status"><i id="stat_{{ $u->id }}" class="fas fa-lock blocked @if($u->deleted_at) disabled @endif"></i></a>
        @endif
    </td>
    <td class="actions text-center">
        @if($u->deleted_at)
            <a href="{{ route('dashboard.users.restore', $u->id) }}" id="status_{{ $u->id }}" data-item-id="{{ $u->id }}" class="restore d-inline mr-2">
                <i id="stat_{{ $u->id }}" class="icon fas fa-trash-restore"></i>
            </a>
            <a href="{{ route('dashboard.users.delete', $u->id) }}" data-item-id="{{ $u->id }}" class="delete d-inline">
                <i class="icon far fa-trash-alt"></i>
            </a>
        @else
            <a href="{{ route('dashboard.users.edit', $u->id) }}" class="d-inline mr-2">
                <i class="icon fas fa-edit"></i>
            </a>
            <a href="{{ route('dashboard.users.destroy', $u->id) }}" data-item-id="{{ $u->id }}" class="destroy d-inline">
                <i class="icon far fa-trash-alt"></i>
            </a>
        @endif
    </td>
</tr>
