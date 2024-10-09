<tr id="rowID_{{ $item->id }}" class="rows @if($item->deleted_at) deleted @endif">
	<td class="id">
		{{ $item->id }}
	</td>
	<td class="title">
		<a href="{{ route('news.edit', ['id' => $item->id]) }}" class="name">{{ $item->title }}</a>
	</td>
	<td class="published_date">
		@if($item->publication_date)
			{{ \Carbon\Carbon::parse($item->publication_date)->format('d.m.Y') }}
		@else
			{{ \Carbon\Carbon::parse($item->created_at)->format('d.m.Y')}}
		@endif
	</td>
    <td class="status text-center">
		@if($item->published)
			<a href="{{ route('news.updateStatus', ['id' => $item->id]) }}" id="status_{{ $item->id }}" data-item-id="{{ $item->id }}" class="updStatus"><i id="stat_{{ $item->id }}" class="far fa-circle published @if($item->deleted_at) disabled @endif"></i></a>
		@elseif(!$item->published)
			<a href="{{ route('news.updateStatus', ['id' => $item->id]) }}" id="status_{{ $item->id }}" data-item-id="{{ $item->id }}" class="updStatus"><i id="stat_{{ $item->id }}" class="far fa-circle unpublished @if($item->deleted_at) disabled @endif"></i></a>
		@endif
    </td>
	<td class="actions text-center">
        @if($item->deleted_at)
            <a href="{{ route('news.restore', ['id' => $item->id]) }}" id="status_{{ $item->id }}" data-item-id="{{ $item->id }}" class="restore d-inline mr-2 restore-link">
                <i id="stat_{{ $item->id }}" class="icon fas fa-trash-restore"></i>
            </a>
            <a href="{{ route('news.destroy', ['id' => $item->id]) }}" data-item-id="{{ $item->id }}" class="delete d-inline delete-link">
                <i class="icon far fa-trash-alt"></i>
            </a>
        @else
            <a href="{{ route('news.edit', ['id' => $item->id]) }}" class="d-inline mr-2">
                <i class="icon fas fa-edit"></i>
            </a>
            <a href="{{ route('news.delete', ['id' => $item->id]) }}" data-item-id="{{ $item->id }}" class="destroy d-inline delete-link">
                <i class="icon far fa-trash-alt"></i>
            </a>
        @endif
    </td>
</tr>
