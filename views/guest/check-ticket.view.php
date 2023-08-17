<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="<?php asset('css/styles.css'); ?>"/>
    <title><?php echo $guest->name ?>'s Tickets</title>
</head>

<body>
<div class="form-container container full-page-wrapper">
    <h1>Tickets you submitted</h1>
    <?php foreach ($tickets->data() as $ticket) { ?>
        <article class="information card">
            <div class="card-head-wrapper">
                <span class="tag"><?= $ticket->importance() ?></span>
                <span class="tag"><?= $ticket->status() ?></span>
                <time><?= $ticket->issued_date ?></time>
            </div>
            <h2 class="title"><?= htmlspecialchars($ticket->title) ?></h2>
            <p class="info">
                <?= htmlspecialchars($ticket->description) ?>
            </p>
            <label for="">Comment:</label>
            <p class="info">
                <?= isset($ticket->comment) ? htmlspecialchars($ticket->comment) : '' ?>
            </p>
        </article>
    <?php } ?>

    <div class="filters-container mt-50">
        <?php if ($tickets->hasPrevious()) { ?>
            <a href="<?php echo $tickets->previous() ?>&t=<?php echo $t ?>"><span class="tag">Previous</span></a>
        <?php } ?>
        <?php for ($i = 1; $i <= $tickets->totalPages(); $i++) { ?>
            <a href="<?php echo $tickets->getPage($i) ?>&t=<?php echo $t ?>"><span
                        class="tag"><?php echo $i ?></span></a>
        <?php } ?>
        <?php if ($tickets->hasNext()) { ?>
            <a href="<?php echo $tickets->next() ?>&t=<?php echo $t ?>"><span class="tag">Next</span></a>
        <?php } ?>
    </div>
</div>
</body>
</html>
