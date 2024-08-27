<tr id="rowID_{{ $item->id }}" class="rows @if($item->deleted_at) deleted @endif">
	<td class="id">
		{{ $item->id }}
	</td>
	<td class="title">
		<a href="/dashboard/organizations/departments/update/{{$item->id}}" class="name">{{ $item->name }}</a>
	</td>
	<td class="status-blocked text-center">
		@if($item->deleted_at)
			<i class="far fa-circle"></i>
		@else
			@if(!$item->is_blocked)
				<a href="" id="status_{{ $item->id }}" data-item-id="{{ $item->id }}" class="toggle-blocked-status"><i id="stat_{{ $item->id }}" class="fas fa-lock-open unblocked"></i></a>
			@elseif($item->is_blocked)
				<a href="" id="status_{{ $item->id }}" data-item-id="{{ $item->id }}" class="toggle-blocked-status"><i id="stat_{{ $item->id }}" class="fas fa-lock blocked"></i></a>
			@endif
		@endif
	</td>
	<td class="actions text-center">
		@if($item->deleted_at)
			<a href="" id="status_{{ $item->id }}" data-item-id="{{ $item->id }}" class="restore d-inline mr-2">
                <i id="stat_{{ $item->id }}" class="icon fas fa-trash-restore"></i>
            </a>
			<a href="/dashboard/organizations/departments/delete?{{$item->id}}" data-item-id="{{ $item->id }}" class="delete d-inline">
                <i class="icon far fa-trash-alt"></i>
            </a>
		@else
			<a href="/dashboard/organizations/departments/update/{{$item->id}}" class="d-inline mr-2">
                <i class="icon fas fa-edit"></i>
            </a>
            <a href="/dashboard/organizations/departments/delete?{{$item->id}}" data-item-id="{{ $item->id }}" class="destroy d-inline">
                <i class="icon far fa-trash-alt"></i>
            </a>
		@endif
	</td>
</tr>
