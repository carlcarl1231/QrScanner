<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="send.php" method="post">
        <label for="number">Number</label>
        <input type="text" name="number" id="number" />

        <label for="message">Message</label>
        <textarea name="message" id="message"></textarea>

        <fieldset>
            <legend>Provider</legend>
            <label>
                <input type="radio" name="provider" value="infobip" checked /> Infobip
            </label>
            <br>
            <label>
                <input type="radio" name="provider" value="twilio" /> Twilio 
            </label>
            <br>
            <button> Send</button>
        </fieldset>

    </form>
    
</body>
</html>