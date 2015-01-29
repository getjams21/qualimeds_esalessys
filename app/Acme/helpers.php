<?php 

function errors_for($attribute, $errors)
{
	return $errors ->first($attribute,'<i class="error">:message</i>');
}
function dateformat($date){
	return date("m/d/Y",strtotime($date));
}
function fullname($user){
	return ucfirst($user->Lastname).', '.ucfirst($user->Firstname).' '.ucfirst($user->MI).'.';
}
function isAdmin(){
	if(Auth::user()->UserType == 1 ||Auth::user()->UserType == 11){
		return true;
	}else{
		return false;
	}
}
function money($money){
	$newmoney = number_format($money,2);
	return $newmoney;
}
function objectToArray($d) {
	if (is_object($d)) {
	// Gets the properties of the given object
	// with get_object_vars function
	$d = get_object_vars($d);
	}
	
	if (is_array($d)) {
	/*
	* Return array converted to object
	* Using __FUNCTION__ (Magic constant)
	* for recursive call
	*/
	return array_map(__FUNCTION__, $d);
	}
	else {
	// Return array
	return $d;
	}
	}