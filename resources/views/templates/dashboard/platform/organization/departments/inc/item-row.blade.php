<tr id="rowID_{{ $item->id }}" class="rows @if($item->deleted_at) deleted @endif">
	<td class="id">
		{{ $item->id }}
	</td>
	<td class="title">
		<a href="{{route('departments.view.edit',['id' => $item->id])}}" class="name">{{ $item->name }}</a>
	</td>
	<td class="status-blocked text-center">
		@if($item->deleted_at)
			<i class="far fa-circle"></i>
		@else
            @if(!$item->is_blocked)
                <a onclick="updateStatus({{$item->id}});return false" id="status_{{ $item->id }}" data-item-id="{{ $item->id }}" class="toggle-blocked-status"><i id="stat_{{ $item->id }}" class="fas fa-lock-open unblocked"></i></a>
            @elseif($item->is_blocked)
                <a onclick="updateStatus({{$item->id}});return false" id="status_{{ $item->id }}" data-item-id="{{ $item->id }}" class="toggle-blocked-status"><i id="stat_{{ $item->id }}" class="fas fa-lock blocked"></i></a>
            @endif
		@endif
	</td>
	<td class="actions text-center">
		@if($item->deleted_at)
			<a href="{{route('departments.restore',['id' => $item->id])}}" id="status_{{ $item->id }}" data-item-id="{{ $item->id }}" class="restore d-inline mr-2 restore-link">
                <i id="stat_{{ $item->id }}" class="icon fas fa-trash-restore"></i>
            </a>
			<a href="{{route('departments.destroy',['id' => $item->id])}}" data-item-id="{{ $item->id }}" class="delete d-inline delete-link">
                <i class="icon far fa-trash-alt"></i>
            </a>
		@else
			<a href="{{route('departments.view.edit',['id' => $item->id])}}" class="d-inline mr-2">
                <i class="icon fas fa-edit"></i>
            </a>
            <a href="{{route('departments.delete',['id' => $item->id])}}" data-item-id="{{ $item->id }}" class="destroy d-inline delete-link">
                <i class="icon far fa-trash-alt"></i>
            </a>
		@endif
	</td>
</tr>
