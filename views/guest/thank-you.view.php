<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Thank You</title>
    <link rel="stylesheet" href="<?php asset('css/thank-you/styles.css') ?>"/>
</head>
<body>
<div class="thanks-content">
    <div class="thanks-wrapper-1">
        <div class="thanks-wrapper-2">

            <?php if (!$encryptedUrl) { ?>
                <h1>Hmmmmm.</h1>
                <p>It's either you entered this page by mistake or you just refreshed the page.</p>
                <p>
                    Thank you again if you have submitted a ticket and if you haven't yet, please do.
                </p>
            <?php } else { ?>
                <h1>Thank you !</h1>
                <p>Thanks for sharing your ticket with us.</p>
                <p>
                    use
                    <a
                            href="/check-tickets?t=<?php echo $encryptedUrl ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                    >this link </a
                    >to track your ticket status
                </p>
            <?php } ?>


            <a class="go-home" href="/">Submit a ticket</a>
        </div>
    </div>
</div>
</body>
</html>
