<?php namespace Acme\Forms;
use Laracasts\Validation\FormValidator;

class SOEntryForm extends FormValidator {

	protected $rules = [
		'CustomerNo' => 'required',
		'UserNo' => 'required',
		'PreparedBy' => 'required'
		];
}