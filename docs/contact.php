<?php
    define("TITLE", "Contact Us | Franklin's Fine Dining");

    include('includes/header.php');

?>

    <div id="contact">
        <hr>
        <h1>Get in touch with us!</h1>

        <?php

            // Check for header injections:
            function has_header_injection($str){
                return preg_match("/[\r\n]/", $str);
            }

            // Check to see if Submit button was pressed:
            if(isset($_POST['contact_submit'])){

                $name = trim($_POST['name']);
                $email = trim($_POST['email']);
                $msg = $_POST['message'];

                // Check to see if $name or $email have header injections:
                if(has_header_injection($name) || has_header_injection ($email)){
                    die(); // If true, kill the script
                }

                // Check to see if any fields are empty:
                if(!$name || !$email || !$msg) {
    				echo '<h4 class="error">All fields required.</h4><a href="contact.php" class="button block">Go back and try again</a>';
    				exit;
    			}

                // Add the receipent email to a variable:
                $to = "hcorbett029@gmail.com";

                // Create a Subject
                $subject = "$name sent you a message via your contact form";

                // Construct the message
                $message = "Name: $name\r\n";
                $message .= "Email: $email\r\n";
                $message .= "Message: \r\n$msg";

                // If the subscribe checkbox was checked...
                if(isset($_POST['subscribe']) && $_POST['subscribe'] == 'Subscribe'){

                    // Add a new line to the $message
                    $message .= "\r\n\r\nPlease add $email to the mailing list.\r\n";
                }

                $message = wordwrap($message, 72);

                // Set the mail headers into a variable
                $headers = "MIME-Version: 1.0\r\n";
    			$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
    			$headers .= "From: " . $name . " <" . $email . ">\r\n";
    			$headers .= "X-Priority: 1\r\n";
    			$headers .= "X-MSMail-Priority: High\r\n\r\n";

                // Send the email
                mail($to, $subject, $message, $headers);

        ?>

        <!-- Show success message after email has sent -->
        <h5>Thanks for contacting Franklin's.</h5>
        <p>Please allow 24 hours for a response.</p>
        <p><a href="index.php" class="button block">&laquo; Go to Home Page</a></p>

    <?php } else{ ?>

        <form id="contact-form" action="" method="post">

            <label for="name">Your Name</label>
            <input type="text" name="name" id="name">

            <label for="email">Your Email</label>
            <input type="email" name="email" id="email">

            <label for="message">and your message</label>
            <textarea name="message" id="message"></textarea>

            <input type="checkbox" name="subscribe" id="subscribe" value="Subscribe">
            <label for="subscribe">Subscribe to newsletter</label>

            <input type="submit" name="contact_submit" class="button next" value="Send Message">

        </form>

        <?php } ?>

        <hr>

    </div> <!-- contact -->

<?php include('includes/footer.php') ?>