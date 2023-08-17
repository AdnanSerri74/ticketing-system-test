<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?php asset('css/styles.css') ?>" />
    <title>New Ticket</title>
</head>

<body>
<div class="form-container container">
    <h1>New Ticket</h1>
    <form method="POST" action="/submit" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="POST">
        <fieldset>
            <legend>Ticket Info</legend>
            <hr />

            <div>
                <label for="title">Title</label>
                <input id="title" name="title" type="text" required />
            </div>

            <div>
                <label for="description">Description</label>
                <textarea
                        id="description"
                        name="description"
                        required
                ></textarea>
            </div>

            <div>
                <label for="attachment">Attachment</label>
                <input
                        id="attachment"
                        name="attachment"
                        type="file"
                        required
                />
            </div>

            <div class="importance-choices">
                <label for="importance">Importance</label>
                <div>
                    <input
                            type="radio"
                            name="importance"
                            value="1"
                            id="normal-importance"
                            checked
                    />
                    <label id="normal-label" for="normal-importance"
                    >Normal</label
                    >
                </div>
                <div>
                    <input
                            type="radio"
                            name="importance"
                            value="2"
                            id="important-importance"
                    />
                    <label
                            id="important-label"
                            for="important-importance"
                    >Important</label
                    >
                </div>
                <div>
                    <input
                            type="radio"
                            name="importance"
                            value="3"
                            id="urgent-importance"
                    />
                    <label id="urgent-label" for="urgent-importance"
                    >Urgent</label
                    >
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>Personal Info</legend>
            <hr />
            <div>
                <label for="name">Name</label>
                <input id="name" name="name" type="text" required />
            </div>
            <div>
                <label for="email">Email</label>
                <input id="email" name="email" type="email" required />
            </div>
            <div>
                <label for="phone">Phone number</label>
                <input id="phone" name="phone_number" type="text" required />
            </div>
        </fieldset>
        <input type="submit" value="Submit a ticket" />
    </form>
</div>
</body>
</html>
