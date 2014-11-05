<?php namespace Acme\Forms;

use Laracasts\Validation\FormValidator;

/**
* registration form
*/
class RegistrationForm extends FormValidator
{
	protected $rules = [
		'username' => 'required|unique:users',
		'password' => 'required|confirmed',
		'Lastname' => 'required',
		'Firstname' => 'required',
		'MI' => 'required',
		'UserType'	=> 'required|integer'
	];
}