<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This creates a debugger for PHP which will output messages to the console
 */
function console( $data ) {

    if ( is_array( $data ) ) {
        $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    } else {
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
    }
    echo $output;
}

?>
