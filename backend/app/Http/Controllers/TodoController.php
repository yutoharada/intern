<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = Auth::id();
        // dd($id);
        $todos = Todo::whereUser_id($id)->get();
        if ($request->has('asc')) {
            $todos = Todo::oldest()->get();
        } else if ($request->has('desc')){
            $todos = Todo::latest()->get();
        }
        return view('todo.index',['todos' => $todos]);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = Auth::id();
        // dd($id);
        $todo = new Todo();
        $todo->title = $request->title;
        // $form = $request -> all();
        // unset($form['_token']);
        // $todo->fill($form)->save();
        $todo->status = 0;
        $todo->user_id = $id;
        // $todo = $request->all();
        $todo->save();

        return redirect('todos')->with(
            'success',
            'ID : ' . $todo->id . '「' . $todo->title . '」を登録しました！'
        );
    }

    //編集ボタン
    public function edit(Request $request)
    {
        $todo = Todo::find($request->id);
        $count = 0;
        // int substr_count { string $todo , string '【Edited】'}
        return view('todo.edit',compact('todo'));
    }

    //更新ボタン
    public function update(Request $request)
    {
        $todo = Todo::find($request->id);
        $todo->title = $request->title;
        $todo->title .= '【Edited】';
        $todo->save();
        return redirect('/');
    }

    //削除ボタン
    public function destroy(Request $request)
    {
        $todo = Todo::find($request->id);
        $todo->delete();
        return redirect()->route('todo.index');
    }

    //完了ボタン
    public function completion(Request $request)
    {
        // dd($request->status);
        $todo = Todo::find($request->id);
        if ($todo->status == 0) {
            $todo->status = 1;
        } else {
            $todo->status = 0;
        }
        $todo->save();
        return redirect()->route('todo.index');
    }

    //OLDかNEWのボタン
    // public function line(Request $request)
    // {
    //     if ($request->has('asc')) {
    //         $todo = Todo::orderBy('updated_at', 'asc')->get();
    //     } else if ($request->has('desc')){
    //         $todo = Todo::orderBy('updated_at', 'desc')->get();
    //     }
    //     return redirect()->route('todo.index');
    // }
}
