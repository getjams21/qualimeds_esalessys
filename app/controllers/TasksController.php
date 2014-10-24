<?php

class TasksController extends BaseController {

	public function index(){
		$tasks = Task::all();

		return View::make('tasks.index')->with('tasks',$tasks);
	}

	public function show($id){
		try {

			$task = Task::findOrFail($id);
			return View::make('tasks.show')->with('task',$task);
			
		} catch (Exception $e) {
		return Redirect::to('404');
		}
	}
}