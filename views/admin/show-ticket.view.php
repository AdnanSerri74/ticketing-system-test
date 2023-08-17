<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="<?php asset('css/styles.css'); ?>"/>
    <title>Review Ticket</title>
</head>

<body>
<div class="form-container container full-page-wrapper">
    <h1>Review Ticket</h1>
    <article class="information card">
        <div class="card-head-wrapper">
            <a href="/admin/dashboard"><span class="tag-back">Back</span></a>
            <span class="tag"><?= $ticket->importance() ?></span>
            <time><?= $ticket->issued_date ?></time>
        </div>
        <h2 class="title" style="width: 1000px"><?= htmlspecialchars($ticket->title) ?></h2>
        <hr>
        <p class="info">
            <?= htmlspecialchars($ticket->description) ?>
        </p>
        <hr>
        <div class="card-footer">
            <form method="POST" action="/admin/dashboard/ticket?tid=<?= $ticket->id ?>">
                <input type="hidden" name="_method" value="PATCH">
                <div>
                    <label for="comment">comment</label>
                    <textarea rows="15"
                              id="comment"
                              name="comment"
                              placeholder="Type your comment here."
                    ><?= isset($ticket->comment) ? htmlspecialchars($ticket->comment) : '' ?></textarea>
                </div>
                <div>
                    <label for="status">status</label>
                    <select
                            id="status"
                            name="status"
                    >
                        <option value="P" <?= $ticket->status == 'P' ? 'selected' : '' ?>>Pending</option>
                        <option value="I" <?= $ticket->status == 'I' ? 'selected' : '' ?>>In Progress</option>
                        <option value="C" <?= $ticket->status == 'C' ? 'selected' : '' ?>>Closed</option>
                    </select>
                </div>
                <div>

                    <input type="submit" value="Update"/>

                </div>
            </form>
        </div>
    </article>
</div>
</body>
</html>
