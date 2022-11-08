@extends("layouts.app")
@section("content")
<div class="row">
    <div class="col-10 m-auto">
        <div class="card">
            <div class="card-header "><p class="h5">{{ Auth::user()->name }}のTodo一覧</p></div>
			<div class="card-body">
				<table class="table">
                    <thead>
                        <tr>
                            <th>
                                <a href="/todos/create" class="btn btn-success">作成</a>
                            </th>
                            <th>
                                <form method="GET">
                                    <button type="submit" name="sort" value="asc" class="btn btn-success">OLD</button>
                                    <button type="submit" name="sort" value="desc" class="btn btn-primary">NEW</button>
                                </form>
                            </th>
                        </tr>
                    </thead>
                </table>
				<table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>タスク名</th>
                            <th>カテゴリー</th>
                            <th>ステータス</th> 
                            <th>完了ボタン</th>
                            <th>期日</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="parent-body">
                        @foreach($todos as $todo)
                            <tr id="parent-{{$todo->id}}">
                                <td class="child{{$todo->id}}">{{ $todo->id }}</td>
                                <td class="child{{$todo->id}}" id="child-title-{{$todo->id}}">{{ $todo->title}}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="child{{$todo->id}}"><a class="btn btn-success" href="{{ route('todo.edit', ['id'=>$todo->id]) }}" id="edit-button-{{$todo->id}}">編集</a></td>
                                <td>
                                    <form action="{{ route('todo.destroy', ['id'=>$todo->id]) }}" method="POST">
                                      @csrf
                                      <button class="btn btn-danger" type="submit">削除</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
			</div>
        </div>
    </div>
</div>
@endsection