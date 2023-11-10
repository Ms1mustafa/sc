<?php
class SendMail
{
    public function sendMail($to, $message = null)
    {
        // $to = "mstafawahed1@gmail.com";
        $subject = "New Notification";
        $message .= "\r\nhttps://kcmlscaffolding.online/SCA/";

        $headers = "From: lafarge@kcmlscaffolding.online\r\n";
        $headers .= "Reply-To: lafarge@kcmlscaffolding.online\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $mailSuccess = mail($to, $subject, $message, $headers);

        if ($mailSuccess) {
            return "Email sent successfully";
        } else {
            return "Email sending failed";
        }
    }
}

?>