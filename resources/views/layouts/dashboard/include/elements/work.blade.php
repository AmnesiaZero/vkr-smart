<tr>
    <th scope="row">{{$work->specialty->name}}</th>
    <td>{{$work->student}}</td>
    <td>{{$work->group}}</td>
    <td>{{$work->protect_date}}</td>
    <td>{{$work->name}}</td>
    <td>{{ match($work->assessment){
      0 => 'Без оценки',
      2 => 'Неудовлетворительно',
      3 => 'Удовлетворительно',
      4 => 'Хорошо',
      5 => 'Отлично'
    }
    }}
    </td>
    <td>{{ match($work->self_check){
      0 => 'Не пройдена',
      1 => 'Пройдена'
    }
    }}
    </td>
    <td>
        <span class="bg-active p-2 d-flex align-items-center gap-2">
            <span class="me-2 green-c cursor-p"></span>
            Отчет
        </span>
    </td>
    <td>
        <img src="/images/three_dots.svg" alt="" class="btn-info-box cursor-p"></td>
</tr>
