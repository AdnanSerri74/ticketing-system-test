<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="<?php asset('css/styles.css'); ?>"/>
    <title>Admin Dashboard</title>
</head>

<body>
<form action="/admin/logout" method="POST">
    <input type="hidden" name="_method" value="POST">

    <input class="go-home" type="submit" value="Logout">
</form>
<div class="form-container container full-page-wrapper">
    <h1>All Tickets</h1>
    <div class="filters-container">
        <form action="/admin/dashboard" method="GET">
            <input
                    id="search"
                    name="search"
                    type="text"
                    placeholder="search ..."
                    value="<?= request()->query('search') ?? '' ?>"
            />
            <input type="submit" value="Search">

            <hr>
            <a href="<?php echo '?' . queryString('date', 'asc', 'importance') ?>">
                <span class="tag" style="width: 100px">sort by date</span>
            </a>
            <a href="<?php echo '?' . queryString('importance', 'asc', 'date') ?>">
                <span class="tag" style="width: 200px">sort by importance</span>
            </a>
        </form>
    </div>
    <?php foreach ($tickets->data() as $ticket) { ?>
        <article class="information card">
            <div class="card-head-wrapper">
                <span class="tag"><?= $ticket->importance() ?></span>
                <span class="tag"><?= $ticket->status() ?></span>
                <time><?= $ticket->issued_date ?></time>
            </div>
            <h2 class="title" style="width: 500px"><?= htmlspecialchars($ticket->title) ?></h2>
            <div class="card-footer">
                <a href="/admin/dashboard/ticket?tid=<?php echo $ticket->id ?>"><span class="tag">Check</span></a>
            </div>
        </article>
    <?php } ?>

    <div class="filters-container mt-50">
        <?php if ($tickets->hasPrevious()) { ?>
            <a href="<?php echo $tickets->previous() ?>"><span class="tag">Previous</span></a>
        <?php } ?>
        <?php for ($i = 1; $i <= $tickets->totalPages(); $i++) { ?>
            <a href="<?php echo $tickets->getPage($i) ?>"><span class="tag"><?php echo $i ?></span></a>
        <?php } ?>
        <?php if ($tickets->hasNext()) { ?>
            <a href="<?php echo $tickets->next() ?>"><span class="tag">Next</span></a>
        <?php } ?>
    </div>
</div>
</body>
</html>
