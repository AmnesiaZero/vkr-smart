<table class="table sm selectable">
    <thead class="thead-dark">
    <tr>
        <th scope="col" style="width: 50px">
            <input type="checkbox" name="books" class="select-all"/>
        </th>
        <th scope="col" class="align-middle">Название коллекции</th>
        <th scope="col" class="text-center align-middle" style="width: 220px;">Дата начала подписки</th>
        <th scope="col" class="text-center align-middle" style="width: 220px;">Дата окончания подписки</th>
        <th scope="col" class="book-title text-center align-middle" style="width: 125px">Действия</th>
    </tr>
    </thead>
    <tbody>
    @if(isset($collections) && $collections->total() > 0)
        @foreach($collections as $collection)
            <tr>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="collections[]" value="{{ $collection->id }}"
                               class="custom-control-input collections" id="collection_{{ $collection->id }}">
                        <label class="custom-control-label" for="collection_{{ $collection->id }}"></label>
                    </div>
                </td>
                <td style="vertical-align: middle">
                    <h5 style="line-height: 1">
                        <a href="" target="_blank">{{ $collection->title }}</a>
                    </h5>
                </td>
                <td class="text-center">
                    <input type="text" name="subscription_start_date" class="form-control form-control-sm date"/>
                </td>
                <td>
                    <input type="text" name="subscription_end_date" class="form-control form-control-sm date"/>
                </td>
                <td class="text-center">
                    <button class="btn btn-sm btn-success add-collection" data-collection-id="{{ $collection->id }}">
                        <i class="fas fa-plus"></i> Добавить
                    </button>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="4" class="text-center">
                Нет элементов для отображения
            </td>
        </tr>
    @endif
    </tbody>
</table>
<div class="col-12">
    <div class="row align-items-center mb-5">
        <div class="col-12 col-lg-8 text-uppercase sm">
            {{ $collections->links() }}
        </div>
    </div>
</div>
