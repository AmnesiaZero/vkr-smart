<tr id="rowID_{{ $item->id }}" class="rows">
	<td class="id">
		{{ $item->id }}
	</td>
	<td class="title @if($item->deleted_at) deleted @endif">
		<a href="{{ route('dashboard.organizations.edit', $item->id) }}" class="name">{{ $item->name }}</a>
	</td>
	<td class="access text-center">
        @if(is_null($item->date_start) || is_null($item->date_end))
            неограниченный
        @else
            c {!! date('d.m.Y', $item->date_start) !!} по {!! date('d.m.Y', $item->date_end) !!}
        @endif
	</td>
    <td class="status-basic text-center">
        @if($item->is_basic)
            <a href="{{ route('dashboard.organizations.toggle-basic-status', $item->id) }}" id="status_{{ $item->id }}" data-item-id="{{ $item->id }}" class="toggle-basic-status"><i id="basic_{{ $item->id }}" class="far fa-check-square basic"></i></a>
        @elseif(!$item->is_basic)
            <a href="{{ route('dashboard.organizations.toggle-basic-status', $item->id) }}" id="status_{{ $item->id }}" data-item-id="{{ $item->id }}" class="toggle-basic-status"><i id="basic_{{ $item->id }}" class="far fa-square not-basic"></i></a>
        @endif
    </td>
	<td class="status-premium text-center">
		@if($item->is_premium)
			<a href="{{ route('dashboard.organizations.toggle-premium-status', $item->id) }}" id="status_{{ $item->id }}" data-item-id="{{ $item->id }}" class="toggle-premium-status"><i id="prem_{{ $item->id }}" class="far fa-check-square premium"></i></a>
		@elseif(!$item->is_premium)
			<a href="{{ route('dashboard.organizations.toggle-premium-status', $item->id) }}" id="status_{{ $item->id }}" data-item-id="{{ $item->id }}" class="toggle-premium-status"><i id="prem_{{ $item->id }}" class="far fa-square not-premium"></i></a>
		@endif
	</td>
	<td class="status-blocked text-center">
		@if($item->deleted_at)
			<i class="far fa-circle"></i>
		@else
			@if(!$item->is_blocked)
				<a href="{{ route('dashboard.organizations.toggle-blocked-status', $item->id) }}" id="status_{{ $item->id }}" data-item-id="{{ $item->id }}" class="toggle-blocked-status"><i id="stat_{{ $item->id }}" class="fas fa-lock-open unblocked"></i></a>
			@elseif($item->is_blocked)
				<a href="{{ route('dashboard.organizations.toggle-blocked-status', $item->id) }}" id="status_{{ $item->id }}" data-item-id="{{ $item->id }}" class="toggle-blocked-status"><i id="stat_{{ $item->id }}" class="fas fa-lock blocked"></i></a>
			@endif
		@endif
	</td>
	<td class="actions text-center">
		@if($item->deleted_at)
			<a href="{{ route('dashboard.organizations.restore', $item->id) }}" id="status_{{ $item->id }}" data-item-id="{{ $item->id }}" class="restore d-inline mr-2">
                <i id="stat_{{ $item->id }}" class="icon fas fa-trash-restore"></i>
            </a>
			<a href="{{ route('dashboard.organizations.delete', $item->id) }}" data-item-id="{{ $item->id }}" class="delete d-inline">
                <i class="icon far fa-trash-alt"></i>
            </a>
		@else
			<a href="{{ route('dashboard.organizations.edit', $item->id) }}" class="d-inline mr-2">
                <i class="icon fas fa-edit"></i>
            </a>
            <a href="{{ route('dashboard.organizations.destroy', $item->id) }}" data-item-id="{{ $item->id }}" class="destroy d-inline">
                <i class="icon far fa-trash-alt"></i>
            </a>
		@endif
	</td>
</tr>
