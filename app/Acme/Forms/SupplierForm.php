<?php namespace Acme\Forms;
use Laracasts\Validation\FormValidator;

class SupplierForm extends FormValidator {

	protected $rules = [
		'SupplierName' => 'required',
		'Address' => 'required',
		'Telephone1' => 'required',
		'Telephone2' => 'required',
		'ContactPerson' => 'required'
		];
}