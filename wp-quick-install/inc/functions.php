<?php

if ( ! function_exists( '_' ) ) {
	function _( $str ) {
		echo $str;
	}
}

function sanit( $str ) {
	return addcslashes( str_replace( array( ';', "\n" ), '', $str ), '\\' );
}

// Recursive copying ~ http://php.net/manual/en/function.copy.php#91010
// In case of importing default files
function recurse_copy($src,$dst) { 
    $dir = opendir($src); 
    @mkdir($dst); 
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
                recurse_copy($src . '/' . $file,$dst . '/' . $file); 
            } 
            else { 
                copy($src . '/' . $file,$dst . '/' . $file); 
            } 
        } 
    } 
    closedir($dir); 
} 
