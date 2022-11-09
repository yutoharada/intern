<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $todos = Todo::all();
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
        $todo = new Todo();
        $todo->title = $request->title;
        // $form = $request -> all();
        // unset($form['_token']);
        // $todo->fill($form)->save();
        $todo->status = 0;
        $todo->save();

        return redirect('todos')->with(
            'success',
            'ID : ' . $todo->id . '「' . $todo->title . '」を登録しました！'
        );
    }

    public function edit(Request $request)
    {
        $todo = Todo::find($request->id);
        return view('todo.edit',compact('todo'));
    }

    public function update(Request $request)
    {
        $todo = Todo::find($request->id);
        $todo->title = $request->title;
        $todo->save();
        return redirect('/');
    }

    public function destroy(Request $request)
    {
        $todo = Todo::find($request->id);
        $todo->delete();
        return redirect()->route('todo.index');
    }

    //完了ボタンを押した時の処理
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

}
