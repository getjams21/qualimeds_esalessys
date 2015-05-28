<?php namespace Acme\Repos\User;

interface UserRepository{
	public function getAllActive();
	public function getAll();
	public function getByid($id);
}