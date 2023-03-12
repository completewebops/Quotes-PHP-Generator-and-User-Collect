<?php
  // Array of quotes
  $quotes = array(
    "Be the change you wish to see in the world.",
    "In three words I can sum up everything I've learned about life: it goes on.",
    "Success is not final, failure is not fatal: it is the courage to continue that counts."
  );

  // Check if form is submitted and add new quote to array
  if (isset($_POST['quote'])) {
    $new_quote = $_POST['quote'];
    array_push($quotes, $new_quote);
  }

  // Generate random quote
  $random_index = rand(0, count($quotes) - 1);
  $random_quote = $quotes[$random_index];

  // API endpoint to get random quote
  $api_url = "https://api.quotable.io/random";

  // Make API request and get random quote
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => $api_url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_SSL_VERIFYPEER => false
  ));
  $response = curl_exec($curl);
  $error = curl_error($curl);
  curl_close($curl);
  if (!$error) {
    $api_quote = json_decode($response, true)['content'];
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Random Quote Generator</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
      .container {
        margin-top: 50px;
        text-align: center;
      }
      h1 {
        margin-bottom: 30px;
      }
      .quote {
        margin-bottom: 30px;
        font-size: 24px;
      }
      button {
        margin-top: 20px;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <h1>Random Quote Generator</h1>
      <div class="quote"><?php echo $random_quote; ?></div>
      <button class="btn btn-primary" onClick="window.location.reload();">Refresh</button>
      <h2>Add Your Own Quote</h2>
      <form method="post">
        <div class="form-group">
          <label for="quote">Quote</label>
          <input type="text" class="form-control" id="quote" name="quote">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
      <h2>Random Quote from API</h2>
      <div class="quote"><?php echo $api_quote; ?></div>
    </div>
  </body>
</html>
