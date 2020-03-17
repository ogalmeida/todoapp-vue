<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller{

  public function index(){
    $tasks = Task::where('finished', 0)->get()->toArray();
    return array_reverse($tasks);
  }

  // finished tasks
  public function finished(){
    $tasks = Task::where('finished', 1)->get()->toArray();
    return array_reverse($tasks);
  }

  // Finish tasks
  public function finishTask($id){
    $tasks = Task::find($id);
    $tasks->fill([
      'finished' => true
    ]);
    if($tasks->save()){
      return response()->json('The book successfully deleted');
    } else {
      return response()->json('Dont success');
    }
    
  }

  // unfinish task
  public function unfinishTask($id){
    $tasks = Task::find($id);
    $tasks->fill([
      'finished' => false
    ]);
    if($tasks->save()){
      return response()->json('The book successfully deleted');
    } else {
      return response()->json('Dont success');
    }
    
  }

  // add book
  public function add(Request $request){

    Task::create([
      'title' => $request->input('title'),
      'description' => $request->input('description'),
      'priority' => $request->input('priority'),
    ]);

    return response()->json('The book successfully added');
  }

  // update book
  public function update($id, Request $request){
      $task = Task::find($id);
      $task->update($request->all());

      return response()->json('The book successfully updated');
  }

  // delete book
  public function delete($id){
    $task = Task::destroy($id);

    return response()->json('The book successfully deleted');
  }
}
