<table class="table sm selectable">
    <thead class="thead-dark">
    <tr>
        <th scope="col" style="width: 50px">
            <input type="checkbox" name="books" class="select-all" />
        </th>
        <th scope="col">Название книги</th>
        <th scope="col" class="book-title text-center" style="width: 125px">Действия</th>
    </tr>
    </thead>
    <tbody>
    @if(isset($books) && $books->total() > 0)
        @foreach($books as $book)
            <tr>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="books[]" value="{{ $book->id }}" class="custom-control-input books" id="book_{{ $book->id }}">
                        <label class="custom-control-label" for="book_{{ $book->id }}"></label>
                    </div>
                </td>
                <td style="vertical-align: middle">
                    <h5 style="line-height: 1">
                        <a href="" target="_blank">{{ $book->title }}</a>
                    </h5>
                </td>
                <td class="text-center">
                    <button class="btn btn-sm btn-success add-book" data-book-id="{{ $book->id }}">
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
            {{ $books->links() }}
        </div>
    </div>
</div>
