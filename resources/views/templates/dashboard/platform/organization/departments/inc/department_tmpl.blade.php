<script id="department_tmpl" type="text/x-jquery-tmpl">
        <tr id="department_${id}" class="rows  @{{if deleted_at}} deleted @{{/if}}">
            <td class="id">
               ${id}
            </td>
            <td class="title" onclick="departmentInfo(${id});return false">
                <a href="" class="name">${name}</a>
            </td>
            <td class="status-blocked text-center">
                @{{if deleted_at}}
                <i class="far fa-circle"></i>
                   @{{if is_blocked}}
                        <a href="" id="status_${id}" data-item-id="${id}" class="toggle-blocked-status"><i id="stat_${id}" class="fas fa-lock blocked"></i></a>
                   @{{else}}
                        <a href="" id="status_${id}" data-item-id="${id}" class="toggle-blocked-status"><i id="stat_${id}" class="fas fa-lock unblocked"></i></a>
                   @{{/if}}
                @{{else}}
                <a href="" id="status_${id}" data-item-id="${id}" class="toggle-blocked-status"><i id="stat_${id}" class="fas fa-lock-open unblocked"></i></a>
                @{{/if}}
            </td>
            <td class="actions text-center">
                @{{if deleted_at}}
                <a href="" id="status_${id}" data-item-id="${id}" class="restore d-inline mr-2">
                <i id="stat_${id}" class="icon fas fa-trash-restore"></i>
                </a>
                <a href="" data-item-id="${id}" class="delete d-inline">
                    <i class="icon far fa-trash-alt"></i>
                </a>
                @{{else}}
                <a href="" class="d-inline mr-2" onclick="openUpdateDepartmentModal(${id});return false">
                <i class="icon fas fa-edit" ></i>
                </a>
                <a href="" data-item-id="${id}" class="destroy d-inline" onclick="deleteDepartment(${id});return false">
                    <i class="icon far fa-trash-alt"></i>
                </a>
                @{{/if}}
            </td>
        </tr>

    </script>
