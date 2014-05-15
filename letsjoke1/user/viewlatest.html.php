<?php include $_SERVER['DOCUMENT_ROOT'] .
        '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h1>Newest jokes</h1>
        <?php if (isset($latests)): ?>
        <table>
            <tr><th>Joke Text</th><th>Author</th></tr>
            <?php foreach ($latests as $latest): ?>
            <tr>
                <td><?php htmlout($latest['text']); ?></td>
                <td><?php htmlout($latest['name']); ?></td>
                <td>
                    <form action="" method="POST">
                        <input type="hidden" name="jokeid" value="<?php
                               htmlout($latest['jokeid']); ?>" >
                        <?php $test = FALSE; ?>
                        <?php foreach ($_SESSION['flag'] as $jid): ?> 
                            <?php if ($jid == $latest['jokeid']):?>
                                <input type="button" value="liked"
                                style="background:#E8E6E7" disabled="disabled">                                
                            <?php $test = TRUE; ?>
                            <?php endif; ?>
                            <?php endforeach; ?>
                            <?php if ($test == FALSE): ?>
                              <input type="submit" name="action2" value="like">
                            <?php endif; ?>
                    </form>
                </td>
                <td>
                    <form action="" method="POST">
                        <input type="hidden" name="authorid" value="<?php
                               htmlout($latest['authorid']); ?>" >
                            <?php $test = FALSE; ?>
                            <?php if (isset($friends)):?>
                            <?php foreach ($friends as $friend): ?> 
                            <?php if ($friend['id'] == $latest['authorid']):?>                                
                            <?php $test = TRUE; ?>
                            <?php endif; ?>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            <?php if ($_SESSION['id'] == $latest['authorid'])
                                $test = TRUE; ?>                          
                            <?php if ($test == FALSE): ?>
                              <input type="submit" name="action2" value="Add">
                            <?php endif; ?>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
        <a href=".">Back to Home</a>
    </body>
</html>
