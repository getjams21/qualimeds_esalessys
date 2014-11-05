<?php 

function errors_for($attribute, $errors)
{
	return $errors ->first($attribute,'<i class="error">:message</i>');
}
function dateformat($date){
	return date("d F Y",strtotime($date));
}