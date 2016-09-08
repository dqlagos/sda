function sendRequestApproveMail($conn, $student_email, $confirmation_link, $subject='', $title='', $message=''){
    /*$smtp_host = "secure290.sgcpanel.com";
    $smtp_password = "automailer*123#";
    $smtp_username = "automailer@oandsonsnetwork.com";*/
    
    if(empty(trim($subject))){
       $subject = "Confirmation Request";  
    }
    if(empty(trim($title))){
        $subject = "Confirmation Request";
    }
    if(empty(trim($message))){
        $message = "Please click on the link below to confirm your request";
    }
    
    $sql = "SELECT * FROM settings LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $smtp_host = $row['smtp_host'];
            $smtp_password = $row['smtp_password'];
            $smtp_username = $row['smtp_username'];
        }
    }

    require('PHPMailer/class.phpmailer.php');
    require('PHPMailer/class.smtp.php');
    $mail = new PHPMailer;
    $mail->isSMTP();
    $email = $student_email;//'enenim2000@yahoo.com';
    //$mail->SMTPDebug = 2; //comment out this code for ajax request to work
    $mail->Host = $smtp_host;//'secure290.sgcpanel.com';
    $mail->Port = 465;
    $mail->SMTPAuth = true;
    $mail->Username = $smtp_username;//'automailer@oandsonsnetwork.com';
    $mail->Password = $smtp_password;//'automailer*123#';
    $mail->SMTPSecure = 'ssl';
    $mail->From = $smtp_username;//'automailer@oandsonsnetwork.com';
    $mail->FromName = "Student Digital Assignment";//ucfirst($store_name1) . ' espread application';
    $recipient_name = trim($email);
    $mail->addAddress($email); //Name is optional
    //$mail->addReplyTo("bassey@dqdemos.com","Espread System");
    $mail->isHTML(true); //Set email format to HTML
    date_default_timezone_set ("Africa/Lagos");
    $mail->Subject = "$subject";
    $mail->Body = '<div style="width: 610px;">
<div style="width: 610px;">
        <div style="width: 600px; background-color: ghostwhite; color: red; padding: 10px; text-align: center; font-weight: bold;">
            <span style="">'. $title . '</span><hr/>
        </div>
        <div style="width: 610px; background-color: white; padding: 5px; text-align: center; color: black; font-weight: bold;">
            <span>' . $message . '</span>
        </div>
        <div style="width: 610px; background-color: ghostwhite; padding: 5px; text-align: center; color: black; font-weight: bold;">
            <span class="" style="font-size: xx-large; font-weight: bold; color: orange;">&#8659;</span>
        </div>
        <div style="width: 610px; border-radius: 0; text-align: center; color: white; background-color: #3c8dbc; font-size:18px; font-weight:bold; padding: 5px;">'.  $confirmation_link . '</div>
    </div>
</div>';
    $mail->AltBody = 'Student Digital Assignment ' . $subject;

    if($mail->send()) {
        return "success";
    }else{
        return "failure";
    }
}
