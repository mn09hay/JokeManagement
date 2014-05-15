<form action="" method="post">

    <div>
        <?php
        if (isset($_SESSION['flag'])) {
            unset($_SESSION['flag']);
        }
        ?>
        <input type="hidden" name="action" value="logout">
        <input type="hidden" name="goto" value="/LetsJoke/">
        <input type="submit" value="Log out">
    </div>
</form>
