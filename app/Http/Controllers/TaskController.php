<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// DB操作のために必要。
use App\Models\Task; //追加

// バリデーションチェックのため。Validatorクラスを利用。
use Illuminate\Support\Facades\Validator;//追加

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // Taskモデルのレコードをすべて取得する。これを変数$tasksに入れる
      // $tasks =Task::all();
      
      // Taskモデルのレコードのうち、ステータスが未完了のもののみ取得
      $tasks = Task::where('status', false)->get();
        
      // ビューファイルに「tasks」という変数名で渡す
      // return view('tasks.index', ['tasks' => $tasks]);　と同じ意味。
      // ※PHPの関数compactを使うことで省略して書くことができる
        return view('tasks.index',compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      
    //※ バリデーション※
      
        $rules = [
            'task_name' => 'required|max:100',
        ];
        
        $messages = ['required' => '必須項目です', 'max' => '100文字以下にしてください。'];
      
        Validator::make($request->all(), $rules, $messages)->validate();

      
      
        // モデルをインスタンス化
        $task = new Task;
        
        // モデル->カラム名 = 値で、データを割り当てる
        $task->name= $request->input('task_name');
        
        // データベースに保存
        $task->save();
        
        // 一覧画面にリダイレクト
        return redirect('/tasks');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $task = Task::find($id);
      return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      
      //「編集する」ボタンをおしたとき
      // falseが未完了（０）　trueが完了（１）
      if ($request->status === false) {
        $rules = [
          'task_name' => 'required|max:100',
        ];
        $messages = ['required' => '必須項目です', 'max' => '100文字以下にしてください。'];
      
        Validator::make($request->all(), $rules, $messages)->validate(); 
    
        //該当のタスクを検索
        $task = Task::find($id);
    
        //モデル->カラム名 = 値 で、データを割り当てる
        $task->name = $request->input('task_name');
    
        //データベースに保存
        $task->save();
        
    } else {
      //「完了」ボタンを押したとき      
        
      //該当のタスクを検索
        $task=Task::find($id);
        
      //モデル->カラム名 = 値 で、データを割り当てる
        $task->status = true; //true:完了、false:未完了
        
        $task->save();
        
      }
      
      //リダイレクト
        return redirect('/tasks');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Task::find($id)->delete();
    
      return redirect('/tasks');
    }
}
