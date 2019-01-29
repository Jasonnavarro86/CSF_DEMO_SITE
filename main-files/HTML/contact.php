<?php

if(!$_POST) exit;

function business_way_is_valid_email( $email ) {
	return( preg_match( "/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i", $email ) );
}

if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

$name     = strip_tags( trim( $_POST['name'] ) );
$email    = strip_tags( trim( $_POST['email'] ) );
$comments = strip_tags( trim( $_POST['comments'] ) );

if( '' == $name ) {
	echo '<div class="error_message">Please enter your name.</div>';
	exit();
} else if( '' == $email || ! business_way_is_valid_email( $email ) ) {
	echo '<div class="error_message">Please enter valid email address.</div>';
	exit();
} else if( '' == $comments ) {
	echo '<div class="error_message">Please enter your message.</div>';
	exit();
}

// Configuration option.
// Enter the email email_address that you want to emails to be sent to.
// Example $email_address = "joe.doe@yourdomain.com";
$email_address = "example@themeforest.com";


// Configuration option.
// i.e. The standard subject will appear as, "You've been contacted by John Doe."

$email_subject = 'You\'ve been contacted by ' . $name;


// Configuration option.
// You can change this if you feel that you need to.
// Developers, you may wish to add more fields to the form, in which case you must be sure to add them here.

$email_body = "You have been contacted by $name. Their additional message is as follows." . PHP_EOL . PHP_EOL;
$email_content = "\"$comments\"" . PHP_EOL . PHP_EOL;
$email_reply = "You can contact $name via email, $email";

$message = wordwrap( $email_body . $email_content . $email_reply, 70 );

$headers = "From: $email" . PHP_EOL;
$headers .= "Reply-To: $email" . PHP_EOL;
$headers .= "MIME-Version: 1.0" . PHP_EOL;
$headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
$headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;

if( mail( $email_address, $email_subject, $message, $headers ) ) {

	// Email has sent successfully, show success message.
	echo "<fieldset>";
	echo "<div id='success_page'>";
	echo "<h2>Email Sent Successfully.</h2>";
	echo "<p>Thank you <strong>$name</strong>, your message has been submitted to us.</p>";
	echo "</div>";
	echo "</fieldset>";

} else {

	echo '<div class="error_message">Error occurred.</div>';

}
exit();
