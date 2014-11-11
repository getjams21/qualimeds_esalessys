<?php 

function errors_for($attribute, $errors)
{
	return $errors ->first($attribute,'<i class="error">:message</i>');
}
function dateformat($date){
	return date("m/d/Y",strtotime($date));
}
function fullame($user){
	return ucfirst($user->Lastname).', '.ucfirst($user->Firstname).' '.ucfirst($user->MI).'.';
}
function isAdmin(){
	if(Auth::user()->UserType == 1 ||Auth::user()->UserType == 11){
		return true;
	}else{
		return false;
	}
}