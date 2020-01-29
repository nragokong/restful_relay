<?php
##############################################################################
#  requirements - must be included in your index.php
##############################################################################
# 

require_once 'lib/fsl.php';



##############################################################################
#  configurations
##############################################################################
#  All in config directory

##############################################################################
#  code to run before route execution
##############################################################################
# 

function before($route)
{
  header("X-LIM-route-function: ".$route['callback']);
  option('routecallback', $route['callback']);
  layout('fsl_default_layout.php');
}

##############################################################################
#  sample routes
##############################################################################
# 
#  routes and controllers
# ----------------------------------------------------------------------------
# Sample RESTFul map:
#
#  HTTP Method |  Url path         |  Controller function
# -------------+-------------------+-------------------------------------------
#   GET        |  /                |  hello_world


//basic hello world
dispatch('/', 'hello_world');

//example showing a json REST response
dispatch('/api', 'api');

dispatch_post('/ftp/:command', 'sftp');
dispatch_post('/ssh', 'ssh');
dispatch_post('/mailer', 'mailer');
//dispatch_post('/smtp', 'smtp');
//dispatch_post('/fan', 'fan');

//example showing JWT usage
dispatch_post('/jwt', 'jwt');

/*
//show session 
dispatch('/showip/:what/:who', 'showip');
   
//kill session 
dispatch('/kill/:who', 'kill_session');
 
//HTTP POST route example. FSL also supports PUT, PATCH, DELETE
dispatch_post('/welcome/:name', 'welcome');
 
//other random examples
dispatch('/are_you_ok/:name', 'are_you_ok');
 
    
dispatch('/how_are_you/:name', 'how_are_you');
 
  
dispatch('/images/:name/:size', 'image_show');
 

dispatch('/*.jpg/:size', 'image_show_jpeg_only');
 */

##############################################################################
#  run after function
##############################################################################
# 
 
  
function after($output, $route)
{
  // Uncomment to show request params and response timing
  // Helpful for debuggin
  /*
  $time = number_format( microtime(true) - LIM_START_MICROTIME, 6);
  $output .= "\n<!-- page rendered in $time sec., on ".date(DATE_RFC822)." -->\n";
  $output .= "<!-- for route\n";
  $output .= print_r($route, true);
  $output .= "-->";
  
  */
  
  return $output;
}


run();

##############################################################################
#  Data Models
##############################################################################
#  

##############################################################################
#  layouts (views) and html templates
##############################################################################
#  Layouts are autoloaded from views directory or can be referended
#  as a function like below.

function html_my_layout($vars){ extract($vars);?> 

<!doctype html>
<html lang="en">
  <body>
    Hello world!
  </body>
</html>

<?php  }

function html_welcome($vars){ extract($vars);?> 
<h3>Hello <?php echo $name?>!</h3>
<p><a href="<?php echo url_for('/how_are_you/', $name)?>">How are you <?php echo $name?>?</a></p>
<hr>
<p><a href="<?php echo url_for('/images/soda_glass.jpg')?>">
   <img src="<?php echo url_for('/images/soda_glass.jpg/thumb')?>"></a></p>
<?php }  

##############################################################################
# custom error declaration
##############################################################################
# 
// Custom 404 
function not_found($errno, $errstr, $errfile, $errline){ 
     
     $arr = array('Error' => "$errno $errstr Not Found");
   // status(202); //returns HTTP status code of 202
    status(404); //returns HTTP status code of 202
    return json($arr);
} 
// Custom 500
function server_error($errno, $errstr, $errfile, $errline){ 
 
     $arr = array('Error' => "$errno $errstr ");
   // status(202); //returns HTTP status code of 202
    status(500); //returns HTTP status code of 202
    return json($arr);
} 



?>
