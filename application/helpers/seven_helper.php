<?php
function order_array_by_time_index($array){
    $time_array = array();
    foreach($array as $index => $subarray){
        if(!is_array($subarray)){
            return $array;
        }else{
            foreach($subarray as $key => $value){
                $time_array[$subarray['time']] =  $index;
            }
        }
    }
    krsort($time_array,SORT_NUMERIC);
    $result = array();
    foreach($time_array as $key => $value){
        $result[] = $array[$value];
    }
    return $result;
}

function load_m_model($file = ""){
    $needed = "../application/models/".$file.".php";
    if(file_exists($needed)){
        require_once($needed);
    }else{
        die("The file <b>\"".$file.".php\"</b> seems not to exit in the models dir...");
        exit;
    }
}
function load_partial($file = "", $args = NULL){
    $needed = "../application/views/partials/".$file."_partial.php";
    if(file_exists($needed)){
        $args = $args;
        require($needed);
    }else{
        die("The file <b>\"".$file."_partial.php\"</b> seems not to exit as a true partial file.");
        exit;
    }
}
//////////////////////////////////////////////////
function datetime_to_txt($datetime="") {
    $unixdatetime = strtotime($datetime);
    return strftime("%B %d, %Y", $unixdatetime);
}
function datetime_to_txt_format($datetime="") {
    $unixdatetime = strtotime($datetime);
    return strftime("%B %d, %Y [%I:%M %p]", $unixdatetime);
}
function unix_to_human($datetime=""){
    return date("Y-m-d h:m:s ",$datetime);
}
function time_ago($time){
    ?>
    <time class="timeago" datetime="<?=$time?>">
        <?=$time?>
    </time>
    <?php
}

// --------------------------------------------------------------------
function encrypt($string = ""){
    $enc = new CI_Encryption();
    return $enc->encrypt($string);
}
function decrypt($string = ""){
    $enc = new CI_Encryption();
    return $enc->decrypt($string);
}
function encrypt_string_and_encode($string) {
    return base64_encode(encrypt($string));
}

// Decode before decryption
function decrypt_string_and_decode($string) {
    return decrypt(base64_decode($string));
}
function toker($compare=''){
    if(!isset($_POST['token'])){
        show_error($message="Someting certainly went wrong. That is all what we know.", $status_code="500", $heading = 'Oops! An Error Was Encountered.');
    }else{
        $de_tok = decrypt($_POST['token']);
        if($compare != $de_tok){
            show_error($message="Someting certainly went wrong. That is all what we know.", $status_code="500", $heading = 'Oops! An Error Was Encountered.');
        }
    }
}

function send_mail($to = 'triplekinsola@gmail.com', $subject="Sup!", $body = ""){
    require_once "../application/helpers/mailer_helper.php";
    $mail = new Mailer();
    $body = "
        <html>
            <head><title>{$subject}</title></head>
            <body>
                <div style='border: 2px solid #306; background-color: #F0F0F0'>
                    <div style='width: 100%; padding: 20px; color: #fff; background-color: #306;'>
                        <a href='http://upin5.net'><img src='".ASSETPATH."img/gfwrfdsfs.png'  alt='www.upin5.net'></a>
                    </div>
                    <div style='padding: 25px;'>
                        <h1 style='background-color: #fff; border-radius: 5px; padding: 5px;'>{$subject}</h1>
                        <p style='font-size: 14px;'>
                        {$body}
                        </p>
                    </div>
                </div>
                <p>
                    This mail was addressed from <a href='http://upin5.net'>www.upin5.net</a> based on a user event that is registered with this mail address, please ignore if you don't know of this event.
                </p>
            </body>
        </html>
    ";
    $sent_mail = $mail->send_mail($to, $subject, $body);
    if($sent_mail){
        return true;
    }else{
        return false;
    }
}

function our_error($heading = 'An Error Was Encountered.', $message="Something certainly went wrong."){
    show_error($message, $status_code="500", $heading);
}
function flash_hash($msg = ""){
    $_SESSION['msg'] = $msg;
}
function form_error(){
    if(validation_errors()){
        ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h6 class="page-header m-top-0" style="font-weight: bold;">Errors:</h6>
            <?=validation_errors() ?>
        </div>
        <?php
    }
}
function file_error($error){
    if(!empty($error)){
        foreach($error as $er){
            ?>
            <div>
                <b class="text-danger"><i class="glyphicon glyphicon-asterisk"></i> <?=$er ?> </b>
            </div>
            <?php
        }
        ?>
        <?php
    }
}

function add_s_pluralize($var){
    if($var > 1) echo "s";
}