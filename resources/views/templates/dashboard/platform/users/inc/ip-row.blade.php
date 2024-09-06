<tr id="rowID_{{ $ip->id }}">
    <td class="ip-ranges font-weight-normal">
        {!! long2ip($ip->ip_left) !!} &mdash; {!! long2ip($ip->ip_right) !!}
    </td>
    <td class="actions text-center">
        <a href="{{ route('dashboard.users.ip.delete', $ip->id) }}" data-item-id="{{ $ip->id }}" class="delete-ip d-inline">
            <i class="icon far fa-trash-alt"></i>
        </a>
    </td>
</tr>
