<?php
    /*
     Plugin Name: WPComment Blacklist support for Gravity Forms
     Description: This Plugin adds Comment Blacklist support to Gravity Forms and prevents spam submisions.
     Author: Usman siddique
     Version: 1.2.0
     */
    
    add_action('admin_menu', 'gravityforms_blacklist_support');
    
    function gravityforms_blacklist_support() {
        
        add_menu_page('WPComment Blacklist support for Gravity Forms Settings', 'GF Blacklist Settings', 'administrator', __FILE__, 'gravityforms_blacklist_support_dashboard' );
        
        add_action( 'admin_init', 'gravityforms_blacklist_support_regis_sett' );
        
    }
    
    function gravityforms_blacklist_support_regis_sett() {
        register_setting( 'gravityforms-blacklist-sett-group', 'selected_forms' );
    }
    function gravityforms_blacklist_excute() {
        $values = esc_attr( get_option('selected_forms') );
        $arrfields = explode(',', $values);
        foreach ( $arrfields as $vr){
            //echo $vr;
            add_filter( 'gform_field_validation_'.$vr, function ( $result, $value, $form, $field ) {
            $master = trim( get_option( 'blacklist_keys' ) );
            $blacklistedwords = explode( "\n", $master );
            foreach ( (array) $blacklistedwords as $blacklistedword ) {
            $blacklistedword = trim( $blacklistedword );
            $regexcheckword = sprintf( '#%s#i', preg_quote( $blacklistedword, '#' ) );

            if ( preg_match( $regexcheckword, $value ) ) {
            $result['is_valid'] = false;
            $result['message']  = 'Please enter valid Characters.';
                                          
                           }
                           
                       }
            return $result;

                       }, 10, 4 );
        }
    }
    //Custom Styleing
    add_action('admin_enqueue_scripts', 'gravityforms_blacklist_support_css');
    
    function gravityforms_blacklist_support_css($hook) {

        wp_enqueue_style('gfsb_css', plugins_url('inc/css/gfsbstyle.css',__FILE__ ));
        wp_enqueue_script('gfsb_script', plugins_url('inc/js/gfsbscript.js',__FILE__ ));
    }
    //end
    $values = esc_attr( get_option('selected_forms') );
    $arrfields = explode(',', $values);
    foreach ( $arrfields as $vr){
        add_filter( 'gform_field_validation_'.$vr, function ( $result, $value, $form, $field ) {
                   $master = trim( get_option( 'blacklist_keys' ) );
                    $blacklistedwords = explode( "\n", $master );
                    foreach ( (array) $blacklistedwords as $blacklistedword ) {
                    $blacklistedword = trim( $blacklistedword );
                    $regexcheckword = sprintf( '#%s#i', preg_quote( $blacklistedword, '#' ) );

                    if ( preg_match( $regexcheckword, $value ) ) {
                    $result['is_valid'] = false;
                    $result['message']  = 'Please enter valid Characters.';
                                                  
                                   }
                                   
                               }
                    return $result;
                   }, 10, 4 );
    }
    function gravityforms_blacklist_support_dashboard() {
    ?>
<div class="html-render">
<div class="lef-block">
<h1>WPComment Blacklist support for Gravity Forms</h1>

<form method="post" action="options.php">
<?php settings_fields( 'gravityforms-blacklist-sett-group' ); ?>
<?php do_settings_sections( 'gravityforms-blacklist-sett-group' ); ?>
<table class="tableclass">
<tr valign="top">
<td>
<h2>Select Form ID:</h2>
<select id="selectform" multiple="multiple" name="select_forms" >
<?php
    $forms = GFAPI::get_forms();
     foreach ( $forms as $form) {
         $formid = $form['id'];
         $formname = $form['title'];
         echo "<option value='".$formid."'>". $formname ."("."ID:".$formid.")"."</option>";
     }
?>
</select>
<div class="anchorwrap"><a id="addforms" class="btn" href="#" onclick="addformsid()">Add</a></div>
</td>
<td style="padding-left:10px;">
<h2>Current Selected IDs:<br></h2>
<textarea id="selectedform" name="selected_forms"><?php echo esc_attr( get_option('selected_forms') ); ?></textarea>
<div class="guides">
<small>Click and Edit Values</small>
<small>Comma(,) separetd e.g.: 1,2,3 </small>
</div>
<div class="anchorwrap"><a class="btn" id="removeforms" href="#" onclick="removeformsid()">Reset</a></div></td>
</tr>
</table>
<?php submit_button(); ?>
</form>
</div>
<div class="right-block">
<h2>If you like this plugin please consider subscribing to my patreon and help me in keeping this plugin updated.</h2>
<a href="https://www.patreon.com/usmansiddique">

<?php
    echo '<img style="max-width:250px;" src="'.plugins_url('images/become_a_patron_button.png',__FILE__ ).'" alt="Become a Patron!" > ';
    ?>
</div>
</div>
<?php }
   
    ?>
