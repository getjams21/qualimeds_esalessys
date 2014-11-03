<?php namespace Acme\Forms;
use Laracasts\Validation\FormValidator;

class SupplierForm extends FormValidator {

	protected $rules = [
		'SupplierName' => 'required',
		'Address' => 'required',
		'Telephone1' => 'required|numeric',
		'Telephone2' => 'required|numeric',
		'ContactPerson' => 'required'
		];
}