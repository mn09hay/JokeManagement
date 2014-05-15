<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/letsjoke1/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Show Jokes</title>
  </head>
  <body>
    <h1>Jokes are coming!</h1>
    <?php if (isset($jokes)): ?>
      <table>
        <tr><th>Joke Text</th></tr>
        <?php foreach ($jokes as $joke): ?>
        <tr>
          <td><?php htmlout($joke['text']); ?></td>
          <td>
              <?php htmlout($joke['date']); ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </table>
    <?php endif; ?>
    <p><a href=".">Return to home</a></p>
  </body>
</html>
