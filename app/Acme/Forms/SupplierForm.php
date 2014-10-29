<?php namespace Acme\Forms;
use Laracasts\Validation\FormValidator;

class SupplierForm extends FormValidator {

	protected $rules = [
		'SupplierName' => 'required|alphaNum',
		'Address' => 'required|alphaNum',
		'Telephone1' => 'required|numeric',
		'Telephone2' => 'required|numeric',
		'ContactPerson' => 'required|alphaNum'
		];
}