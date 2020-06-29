<?php
$errors = array();

function fieldname_as_text($fieldname){
    $fieldname = str_replace("_", " ", $fieldname);
    $fieldname = ucfirst($fieldname);
    return $fieldname;
}

// check presence
function has_presence($value){
    return isset($value) && $value !== "";
}


// check an array of field for an empty submission 
function validate_presence($required_fields){
        global $errors;

        foreach($required_fields as $field){
        $value = trim($_POST[$field]);
        if(!has_presence($value)) {
        $errors[$field] = fieldname_as_text($field)." can't be blank";
                 
            }
        }
}

/// validate string lenth with $max value
function has_max_lenth($value, $max)
{
return strlen($value) <= $max;
}

function validate_max_lenth($fields_with_max_lenths){
    global $errors;

    foreach($fields_with_max_lenths as $field => $max){
    $value = trim($_POST[$field]);

    if (!has_max_lenth($value, $max)){
    $errors[$field] = fieldname_as_text($field) . " is too long";
        }
    } // expect an ass array
} 


// check if a value is available in a set
function has_inclusion_in($value, $set)
{
    return in_array($value, $set);
}

