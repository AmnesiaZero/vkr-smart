<tr id="rowID_{{ $item->id }}" class="rows">
	<td class="id">
		{{ $item->id }}
	</td>
	<td class="title @if($item->deleted_at) deleted @endif">
		<a href="{{ route('organizations.edit', ['id' => $item->id])}} " class="name">{{ $item->name }}</a>
	</td>
	<td class="access text-center">
        @if(is_null($item->start_date) || is_null($item->end_date))
            неограниченный
        @else
{{--            Делал через касты, но они не работают. Пока оставлю так--}}
            {{ \Carbon\Carbon::parse($item->start_date)->format('d.m.Y') }} по {{ \Carbon\Carbon::parse($item->end_date)->format('d.m.Y') }}
        @endif
	</td>
    <td class="status-basic text-center">
        @if($item->is_basic)
            <a onclick="updateBasic({{$item->id}})" id="basic_status_{{ $item->id }}" data-item-id="{{ $item->id }}" class="toggle-basic-status"><i id="basic_{{ $item->id }}" class="far fa-check-square basic"></i></a>
        @elseif(!$item->is_basic)
            <a onclick="updateBasic({{$item->id}})" id="basic_status_{{ $item->id }}" data-item-id="{{ $item->id }}" class="toggle-basic-status"><i id="basic_{{ $item->id }}" class="far fa-square not-basic"></i></a>
        @endif
    </td>
	<td class="status-premium text-center">
		@if($item->is_premium)
			<a onclick="updatePremium({{$item->id}})" id="premium_status_{{ $item->id }}" data-item-id="{{ $item->id }}" class="toggle-premium-status"><i id="premium_{{ $item->id }}" class="far fa-check-square premium"></i></a>
		@elseif(!$item->is_premium)
			<a onclick="updatePremium({{$item->id}})" id="premium_status_{{ $item->id }}" data-item-id="{{ $item->id }}" class="toggle-premium-status"><i id="premium_{{ $item->id }}" class="far fa-square not-premium"></i></a>
		@endif
	</td>
	<td class="status-blocked text-center">
		@if($item->deleted_at)
			<i class="far fa-circle"></i>
		@else
			@if(!$item->is_blocked)
				<a onclick="updateStatus({{$item->id}})" id="status_{{ $item->id }}" data-item-id="{{ $item->id }}" class="toggle-blocked-status"><i id="stat_{{ $item->id }}" class="fas fa-lock-open unblocked"></i></a>
			@elseif($item->is_blocked)
				<a onclick="updateStatus({{$item->id}})" id="status_{{ $item->id }}" data-item-id="{{ $item->id }}" class="toggle-blocked-status"><i id="stat_{{ $item->id }}" class="fas fa-lock blocked"></i></a>
			@endif
		@endif
	</td>
	<td class="actions text-center">
		@if($item->deleted_at)
			<a href="{{ route('organizations.restore', ['id' => $item->id])}}" id="status_{{ $item->id }}" data-item-id="{{ $item->id }}" class="restore d-inline mr-2 restore-link">
                <i id="stat_{{ $item->id }}" class="icon fas fa-trash-restore"></i>
            </a>
            <a href="{{ route('organizations.destroy', ['id' => $item->id])}}" data-item-id="{{ $item->id }}" class="destroy d-inline delete-link">
                <i class="icon far fa-trash-alt"></i>
            </a>
		@else
			<a href="{{ route('organizations.edit', ['id' => $item->id])}}" class="d-inline mr-2">
                <i class="icon fas fa-edit"></i>
            </a>
            <a href="{{ route('organizations.delete', ['id' => $item->id])}}" data-item-id="{{ $item->id }}" class="delete d-inline delete-link">
                <i class="icon far fa-trash-alt"></i>
            </a>
		@endif
	</td>
</tr>
