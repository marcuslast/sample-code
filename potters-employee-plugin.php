<?php
   /*
       Plugin Name: YourPotters Custom AC Plugin
       Plugin URI: http://theonequestion.com
       description: Custom API user export system
       Version: 1.2
       Author: Marcus Last
       License: GPL2
   */

// CREATED DECEMBER 2018
// This plugin creates wordpress users from a CSV

add_action( 'admin_post_nopriv_passwordreset', 'yourpotters_passwordreset' );
add_action( 'admin_post_passwordreset', 'yourpotters_passwordreset' );

add_action( 'admin_post_nopriv_yourpotters_change_password', 'yourpotters_change_password' );
add_action( 'admin_post_yourpotters_change_password', 'yourpotters_change_password' );

add_action( 'admin_post_nopriv_yourpotters_login', 'yourpotters_login' );
add_action( 'admin_post_yourpotters_login', 'yourpotters_login' );

add_action( 'admin_post_nopriv_yourpotters_add_users', 't1q_create_users' );
add_action( 'admin_post_yourpotters_add_users', 't1q_create_users' );

add_action( 'admin_post_nopriv_yourpotters_delete_users', 't1q_delete_users' );
add_action( 'admin_post_yourpotters_delete_users', 't1q_delete_users' );

add_filter( 'wp_mail_from_name', function( $name ) {
	return 'Your Potters';
});

    add_action( 'admin_menu', 'activecampaign_action' );

      function activecampaign_action() {
          # the add_action ensures this is only run when admin pages are displayed
          // add_menu_page( 'UserCreation', 'UserCreation', 'manage_options', 'query-string-parameter', 't1q_create_users');
          add_menu_page( 'UserCreation', 'UserCreation', 'manage_options', 't1q_manage_users_page', 't1q_manage_users_page');
      }     
            function t1q_manage_users_page(){
              ?>
               <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
                  <input type="hidden" name="action" value="yourpotters_add_users">
                  <button id="submitButton" type="submit" class="btn btn-primary">ADD NEW</button>
               </form>
               <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
                  <input type="hidden" name="action" value="yourpotters_delete_users">
                  <button id="submitButton" type="submit" class="btn btn-primary">DELETE</button>
               </form>
              <?php
            }

            function t1q_createToken($length){
                  $token = "";
                  $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                  $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
                  $codeAlphabet.= "0123456789";
                  $max = strlen($codeAlphabet); // edited
            
                for ($i=0; $i < $length; $i++) {
                    $token .= $codeAlphabet[random_int(0, $max-1)];
                }
            
                return $token;
            }

            function t1q_create_users(){
              global $wpdb;
              $url = get_stylesheet_directory().'/new.csv';
            	$content = file_get_contents(get_stylesheet_directory().'/new.csv');
              $lines = array_map("rtrim", explode("\n", $content));
              // END OF GET CSV
            	$counter = 0;
            	foreach($lines as $line => $e){
            		$lines[$counter] = explode(",",$e);
            		$counter++;
              }

            	$email_array = array();
              $counter_l = 0;
              $new_creations = 0;
            	$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
            	foreach($lines as $l){
            		$last_name = $email_array[$counter_l]['last_name'] = $l[0];
            			$first_name = $email_array[$counter_l]['first_name'] = $l[1];
                    $email = $email_array[$counter_l]['email'] = $l[2];
                      // IF EMAIL DOESN'T EXIST THEN EXECUTE
                        if( null == username_exists( $email ) ) {
                          // CREATE RANDOM PASSWORD
                            $password = wp_generate_password( 12, true );
                            // CREATE THE USER AND RETURN USER ID
                              $user_id = wp_create_user ( $email, $password, $email );
                              // EDIT NICKNAME FOR USER
                                    wp_update_user(
                                      array(
                                        'ID'       => $user_id,
                                        'nickname' => $first_name
                                      )
                                    );
                                      // NOW LET'S GET DOWN TO THE SPECIFICS
                                      $user = new WP_User( $user_id );
                                        // SET USERS PERMISSIONS
                                        $user->set_role( 'subscriber' );
                                        // NOW SET A TOKEN IN THE DATABASE SO THEY CAN CHANGE PASSWORD
                                          $token = t1q_createToken(35);
                                            $wpdb->update( 
                                              'wp_users', 
                                              array( 
                                                'token' => $token
                                              ), 
                                              array( 'ID' => $user_id ), 
                                              array( 
                                                '%s'
                                              ), 
                                              array( '%d' ) 
                                            );
                                            $msg1 = file_get_contents(get_stylesheet_directory().'/email_new1.html');
                                            $msg2 = file_get_contents(get_stylesheet_directory().'/email_new2.html');
                                        
                                                  // NOW LET'S EMAIL THE USER SAYING WELCOME TO YOURPOTTERS
                                                  $to = $email;
                                                  $subject = 'Welcome to YourPotters';
                                                  $body = $msg1.'https://yourpotters.com/create-password/?token='.$token.'&id='.$user_id.''.$msg2;
                                                  $headers = array('Content-Type: text/html; charset=UTF-8', 'From: info@yourpotters.com');

                                                  wp_mail( $to, $subject, $body, $headers );
                                                  $new_creations++;

                        }
            		$counter_l++;
              }
              unlink($url);
              echo $new_creations.' users successfully created';
              // END OF LOOP THROUGH EACH ENTRY
            }

            

        function t1q_delete_users(){
          global $wpdb;
          $url = get_stylesheet_directory().'/leavers.csv';
          $content = file_get_contents(get_stylesheet_directory().'/leavers.csv');
          $lines = array_map("rtrim", explode(",", $content));
          // END OF GET CSV
          $counter = 0;
          foreach($lines as $line => $e){
            $lines[$counter] = explode(",",$e);
            $counter++;
          }

          $email_array = array();
          $counter_l = 0;
          $new_creations = 0;
          foreach($lines as $l){
                $email = $email_array[$counter_l]['email'] = $l[0];
                  // IF EMAIL EXIST THEN EXECUTE
                    if( null !== username_exists( $email ) ) {
                      require_once(ABSPATH.'wp-admin/includes/user.php' );
                      $user = $wpdb->get_results("SELECT * FROM wp_users WHERE `user_email` = '$email' LIMIT 1");
                      wp_delete_user( $user[0]->ID );
                    }
            $counter_l++;
          }
          //unlink($url);
          echo $new_creations.' users deleted';
          // END OF LOOP THROUGH EACH ENTRY
        }
          

            function yourpotters_checkToken($token, $id){
               global $wpdb;
               $tokenNew = filter_var($token, FILTER_SANITIZE_STRING);
               $idNew = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
               $results = $wpdb->get_results("SELECT * FROM wp_users WHERE `ID` = '$idNew' AND `token` = '$tokenNew' LIMIT 1");
               if($results[0]->ID === NULL){
                  wp_redirect( '/login?token=expired' );
                  exit;
               }
               else{
               return true;
               }
            } 



            function yourpotters_change_password(){
             
            }

          
            function yourpotters_passwordreset($emailRaw){
              global $wpdb;
              $email = filter_var($emailRaw, FILTER_SANITIZE_EMAIL);
              $results = $wpdb->get_results("SELECT * FROM wp_users WHERE `user_email` = '$email' LIMIT 1");
          
                    if(strtolower($results[0]->user_email) === strtolower($email)){
                            $token = t1q_createToken(35);
                            $wpdb->update( 
                              'wp_users', 
                              array( 
                                'token' => $token,
                              ), 
                              array( 'ID' => $results[0]->ID ), 
                              array( 
                                '%s'
                              )
                            );
          
                            $msg1 = file_get_contents(get_stylesheet_directory().'/email_reset1.html');
                            $msg2 = file_get_contents(get_stylesheet_directory().'/email_reset2.html');
                        
                                  // NOW LET'S EMAIL THE USER SAYING WELCOME TO YOURPOTTERS
                                  $to = $email;
                                  $subject = 'YourPotters Password Reset';
                                  $body = $msg1.'https://yourpotters.com/create-password/?token='.$token.'&id='.$results[0]->ID.'">'.$msg2;
                                  $headers = array('Content-Type: text/html; charset=UTF-8', 'From: info@yourpotters.com');
          
                                  wp_mail( $to, $subject, $body, $headers );

                                  wp_redirect( 'https://www.yourpotters.com/login' );
                                  
                  } // END OF IF
                  else{
                    exit;
                    echo 'No email exists';
                  }
            }

?>
