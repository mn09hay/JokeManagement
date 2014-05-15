<?php

include_once $_SERVER['DOCUMENT_ROOT'] .
        '/letsjoke1/includes/magicquotes.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/letsjoke1/includes/access.inc.php';
if (isset($_POST['action']) and $_POST['action'] == 'register') {
    if ($_POST['Rpassword'] != $_POST['Rrepassword']) {
        $GLOBALS['loginError'] = 'Please input the same password';
        include './login.html.php';
        exit();
    }

    $password = md5($_POST['Rpassword'] . 'ijdb');
    $path = 'pic/default.jpg';
    include $_SERVER['DOCUMENT_ROOT'] . '/letsjoke1/includes/db.inc.php';
    try {
        $sql = 'INSERT INTO author SET
name = :name,
email = :email,
password = :password,
path = :path';
        $s = $pdo->prepare($sql);
        $s->bindValue(':name', $_POST['name']);
        $s->bindValue(':email', $_POST['Remail']);
        $s->bindValue(':password', $password);
        $s->bindValue(':path', $path);
        $s->execute();
    } catch (Exception $ex) {
        $error = 'Error registering new user.' . $ex->getMessage();
        include 'error.html.php';
        exit();
    }

    include 'login.html.php';
    exit();
}
if (!userIsLoggedIn()) {
    include 'login.html.php';
    exit();
}
include $_SERVER['DOCUMENT_ROOT'] . '/letsjoke1/includes/db.inc.php';
try {
    $sql = 'select name, path from author where author.email = :email';
    $s = $pdo->prepare($sql);
    $s->bindValue(':email', $_SESSION['email']);
    $s->execute();
} catch (Exception $ex) {
    $error = 'Error fetching the joke of user' . $ex->getMessage();
    include 'error.html.php';
    exit();
}
foreach ($s as $row) {
    $username = $row['name'];
    $path = $row['path'];
}

if (isset($_GET['action']) and $_GET['action'] == 'search') {
    include $_SERVER['DOCUMENT_ROOT'] . '/letsjoke1/includes/db.inc.php';

    $select = 'SELECT jokedate, joke.id, authorid, joketext, author.name as name';
    $from = ' FROM joke inner join author on authorid = author.id';
    $where = ' WHERE TRUE';
    $order = ' ORDER BY jokedate DESC';

    $placeholders = array();

    if ($_GET['friend'] != '') {
        $where .= " AND authorid = :authorid";
        $placeholders[':authorid'] = $_GET['friend'];
    }

    if ($_GET['category'] != '') {
        $from .= ' INNER JOIN jokecategory ON joke.id = jokeid';
        $where .= " AND categoryid = :categoryid";
        $placeholders[':categoryid'] = $_GET['category'];
    }

    if ($_GET['text'] != '') {
        $where .= " AND joketext LIKE :joketext";
        $placeholders[':joketext'] = '%' . $_GET['text'] . '%';
    }

    try {
        $sql = $select . $from . $where . $order;
        $s = $pdo->prepare($sql);
        $s->execute($placeholders);
    } catch (Exception $ex) {
        $error = 'Error fetchin jokes for searching.' . $ex->getMessage();
        include 'error.html.php';
        exit();
    }

    foreach ($s as $row) {
        $jokes[] = array('jokeid' => $row['id'], 'text' => $row['joketext'],
            'jokedate' => $row['jokedate'], 'name' => $row['name'], 'authorid' => $row['authorid']);
    }
    try {
        $sql = 'select j.rate, j.id as jokeid, fa.id, fa.name, joketext from friendship
inner join author on userid = author.id
inner join joke as j on friendid = j.authorid
inner join author as fa on friendid = fa.id
where author.email = :email';
        $s = $pdo->prepare($sql);
        $s->bindValue(':email', $_SESSION['email']);
        $s->execute();
    } catch (Exception $ex) {
        $error = 'Error fetching jokes of friends.' . $ex->getMessage();
        include 'error.html.php';
        exit();
    }

    foreach ($s as $row) {
        $friends[] = array('name' => $row['name'], 'text' => $row['joketext'],
            'id' => $row['id'], 'jokeid' => $row['jokeid']);
    }


    include 'user/seachresult.html.php';
    exit();
}

if (userHasRole('Content Editor') or
        userHasRole('Account Administrator') or
        userHasRole('SiteAdministrator')) {
    header("Location: ./manage.html");
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/letsjoke1/includes/db.inc.php';
try {
    $sql = 'SELECT id FROM author WHERE email = :email';
    $s = $pdo->prepare($sql);
    $s->bindValue(':email', $_SESSION['email']);
    $s->execute();
} catch (Exception $ex) {
    $error = 'Error for getting the id.';
    include 'error.html.php';
    exit();
}

$result = $s->fetch();
$userid = $result['id'];

$_SESSION['id'] = $userid;
if (!isset($_SESSION['flag'])) {
    $_SESSION['flag'] = array();
}
include $_SERVER['DOCUMENT_ROOT'] . '/letsjoke1/includes/db.inc.php';

if (isset($_POST['action']) and $_POST['action'] == 'Delete') {
    include $_SERVER['DOCUMENT_ROOT'] . '/letsjoke1/includes/db.inc.php';
    try {
        $sql = 'DELETE FROM jokecategory WHERE jokeid = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    } catch (Exception $ex) {
        $error = 'Error removing joke from categories.';
        include 'error.html.php';
        exit();
    }
    try {
        $sql = 'DELETE FROM joke WHERE id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    } catch (Exception $ex) {
        $error = 'Error deleting joke.';
        include 'error.html.php';
        exit();
    }
    try {
        $sql = 'select joke.id, joketext, jokedate, author.name as name from joke
inner join author on authorid = author.id
where author.email = :email
order by jokedate desc';
        $s = $pdo->prepare($sql);
        $s->bindValue(':email', $_SESSION['email']);
        $s->execute();
    } catch (Exception $ex) {
        $error = 'Error fetching the joke of user' . $ex->getMessage();
        include 'error.html.php';
        exit();
    }
    foreach ($s as $row) {
        $jokes[] = array('id' => $row['id'], 'text' => $row['joketext'], 'jokedate' => $row['jokedate'], 'username' => $row['name']);
    }
    include 'user/userhome.html.php';
    exit();
}

if (isset($_POST['action1']) and $_POST['action1'] == 'like') {

    include $_SERVER['DOCUMENT_ROOT'] . '/letsjoke1/includes/db.inc.php';
    try {
        $sql = 'UPDATE joke SET
rate = rate + 1
where id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['jokeid']);
        $s->execute();
    } catch (Exception $ex) {
        $error = 'Error updating joke rating.';
        include 'error.html.php';
        exit();
    }

    try {
        $sql = 'select authorid, joke.id as jokeid, joketext, name from joke
inner join author on authorid = author.id
order by rate desc';
        $s = $pdo->query($sql);
        $s->execute();
    } catch (Exception $ex) {
        $error = 'Error fetching top jokes.';
        include 'error.html.php';
        exit();
    }

    foreach ($s as $row) {
        $tops[] = array('name' => $row['name'], 'text' => $row['joketext'],
            'jokeid' => $row['jokeid'], 'authorid' => $row['authorid']);
    }

    try {
        $sql = 'select j.rate, j.id as jokeid, fa.id, fa.name, joketext from friendship
inner join author on userid = author.id
inner join joke as j on friendid = j.authorid
inner join author as fa on friendid = fa.id
where author.email = :email';
        $s = $pdo->prepare($sql);
        $s->bindValue(':email', $_SESSION['email']);
        $s->execute();
    } catch (Exception $ex) {
        $error = 'Error fetching jokes of friends.' . $ex->getMessage();
        include 'error.html.php';
        exit();
    }

    foreach ($s as $row) {
        $friends[] = array('name' => $row['name'], 'text' => $row['joketext'],
            'id' => $row['id'], 'jokeid' => $row['jokeid']);
    }

    $_SESSION['flag'][] = $_POST['jokeid'];
    include 'user/topjokes.html.php';
    exit();
}

if (isset($_POST['action1']) and $_POST['action1'] == 'Add') {
    try {
        $sql = 'INSERT INTO friendship SET
userid = :userid,
 friendid = :friendid';
        $s = $pdo->prepare($sql);
        $s->bindValue(':userid', $_SESSION['id']);
        $s->bindValue(':friendid', $_POST['authorid']);
        $s->execute();
    } catch (Exception $ex) {
        $error = 'Error for adding friends.';
        include 'error.html.php';
        exit();
    }

    try {
        $sql = 'select authorid, joke.id as jokeid, joketext, name, jokedate from joke
inner join author on authorid = author.id
order by rate desc';
        $s = $pdo->query($sql);
        $s->execute();
    } catch (Exception $ex) {
        $error = 'Error fetching top jokes.';
        include 'error.html.php';
        exit();
    }

    foreach ($s as $row) {
        $tops[] = array('name' => $row['name'], 'text' => $row['joketext'],
            'jokeid' => $row['jokeid'], 'authorid' => $row['authorid'], 'jokedate' => $row['jokedate']);
    }

    try {
        $sql = 'select j.rate, j.id as jokeid, fa.id, fa.name, joketext, jokedate from friendship
inner join author on userid = author.id
inner join joke as j on friendid = j.authorid
inner join author as fa on friendid = fa.id
where author.email = :email';
        $s = $pdo->prepare($sql);
        $s->bindValue(':email', $_SESSION['email']);
        $s->execute();
    } catch (Exception $ex) {
        $error = 'Error fetching jokes of friends.' . $ex->getMessage();
        include 'error.html.php';
        exit();
    }

    foreach ($s as $row) {
        $friends[] = array('name' => $row['name'], 'text' => $row['joketext'],
            'id' => $row['id'], 'jokeid' => $row['jokeid'], 'jokedate' => $row['jokedate']);
    }

    include 'user/topjokes.html.php';
    exit();
}

if (isset($_POST['action2']) and $_POST['action2'] == 'like') {

    include $_SERVER['DOCUMENT_ROOT'] . '/letsjoke1/includes/db.inc.php';
    try {
        $sql = 'UPDATE joke SET
rate = rate + 1
where id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['jokeid']);
        $s->execute();
    } catch (Exception $ex) {
        $error = 'Error updating joke rating.';
        include 'error.html.php';
        exit();
    }

    try {
        $sql = 'select authorid, joke.id as jokeid, joketext, name, jokedate from joke
inner join author on authorid = author.id
order by jokedate desc';
        $s = $pdo->query($sql);
        $s->execute();
    } catch (Exception $ex) {
        $error = 'Error fetching latest jokes.';
        include 'error.html.php';
        exit();
    }

    foreach ($s as $row) {
        $latests[] = array('name' => $row['name'], 'text' => $row['joketext'],
            'jokeid' => $row['jokeid'], 'authorid' => $row['authorid'], 'jokedate' => $row['jokedate']);
    }

    try {
        $sql = 'select j.rate, j.id as jokeid, fa.id, fa.name, joketext, jokedate from friendship
inner join author on userid = author.id
inner join joke as j on friendid = j.authorid
inner join author as fa on friendid = fa.id
where author.email = :email';
        $s = $pdo->prepare($sql);
        $s->bindValue(':email', $_SESSION['email']);
        $s->execute();
    } catch (Exception $ex) {
        $error = 'Error fetching jokes of friends.' . $ex->getMessage();
        include 'error.html.php';
        exit();
    }

    foreach ($s as $row) {
        $friends[] = array('name' => $row['name'], 'text' => $row['joketext'],
            'id' => $row['id'], 'jokeid' => $row['jokeid'], 'jokedate' => $row['jokedate']);
    }

    $_SESSION['flag'][] = $_POST['jokeid'];
    include 'user/latejokes.html.php';
    exit();
}

if (isset($_POST['action2']) and $_POST['action2'] == 'Add') {
    try {
        $sql = 'INSERT INTO friendship SET
userid = :userid,
 friendid = :friendid';
        $s = $pdo->prepare($sql);
        $s->bindValue(':userid', $_SESSION['id']);
        $s->bindValue(':friendid', $_POST['authorid']);
        $s->execute();
    } catch (Exception $ex) {
        $error = 'Error for adding friends.';
        include 'error.html.php';
        exit();
    }

    try {
        $sql = 'select authorid, joke.id as jokeid, joketext, name, jokedate from joke
inner join author on authorid = author.id
order by jokedate desc';
        $s = $pdo->query($sql);
        $s->execute();
    } catch (Exception $ex) {
        $error = 'Error fetching latest jokes.';
        include 'error.html.php';
        exit();
    }

    foreach ($s as $row) {
        $latests[] = array('name' => $row['name'], 'text' => $row['joketext'],
            'jokeid' => $row['jokeid'], 'authorid' => $row['authorid'], 'jokedate' => $row['jokedate']);
    }

    try {
        $sql = 'select j.rate, j.id as jokeid, fa.id, fa.name, joketext, jokedate from friendship
inner join author on userid = author.id
inner join joke as j on friendid = j.authorid
inner join author as fa on friendid = fa.id
where author.email = :email';
        $s = $pdo->prepare($sql);
        $s->bindValue(':email', $_SESSION['email']);
        $s->execute();
    } catch (Exception $ex) {
        $error = 'Error fetching jokes of friends.' . $ex->getMessage();
        include 'error.html.php';
        exit();
    }

    foreach ($s as $row) {
        $friends[] = array('name' => $row['name'], 'text' => $row['joketext'],
            'id' => $row['id'], 'jokeid' => $row['jokeid'], 'jokedate' => $row['jokedate']);
    }

    include 'user/latejokes.html.php';
    exit();
}




if (isset($_GET['addform'])) {
    include $_SERVER['DOCUMENT_ROOT'] . '/letsjoke1/includes/db.inc.php';
    try {
        $sql = 'select id from author where email = :email';
        $s = $pdo->prepare($sql);
        $s->bindValue(':email', $_SESSION['email']);
        $s->execute();
    } catch (Exception $ex) {
        $error = 'Error fetching the user ID.';
        include 'error.html.php';
        exit();
    }
    $result = $s->fetch();
    $userid = $result['id'];
    try {
        $sql = 'insert into joke set
joketext = :joketext,
 jokedate = CURDATE(),
 authorid = :authorid';
        $s = $pdo->prepare($sql);
        $s->bindValue(':joketext', $_POST['text']);
        $s->bindValue(':authorid', $userid);
        $s->execute();
    } catch (Exception $ex) {
        $error = 'Error adding submitted joke from user.';
        include 'error.html.php';
        exit();
    }
    $jokeid = $pdo->lastInsertId();
    if (isset($_POST['categories'])) {
        try {
            $sql = 'insert into jokecategory set
jokeid = :jokeid,
 categoryid = :categoryid';
            $s = $pdo->prepare($sql);
            foreach ($_POST['categories'] as $categoryid) {
                $s->bindValue(':jokeid', $jokeid);
                $s->bindValue(':categoryid', $categoryid);
                $s->execute();
            }
        } catch (Exception $ex) {
            $error = 'Error inserting joke into selected categories.';
            include 'error.html.php';
            exit();
        }
    }
    header('Location: .');
    exit();
}
include $_SERVER['DOCUMENT_ROOT'] . '/letsjoke1/includes/db.inc.php';
//Build the list of categories
try {
    $result = $pdo->query('select id, name from category');
} catch (Exception $ex) {
    $error = 'Error fetching list of categories for user.';
    include 'error.html.php';
    exit();
}
foreach ($result as $row) {
    $categories[] = array(
        'id' => $row['id'],
        'name' => $row['name'],
        'selected' => FALSE);
}
if (isset($_GET['viewuser'])) {
    include $_SERVER['DOCUMENT_ROOT'] . '/letsjoke1/includes/db.inc.php';
    try {
        $sql = 'select joke.id, joketext, author.name as name, jokedate from joke
inner join author on authorid = author.id
where author.email = :email';
        $s = $pdo->prepare($sql);
        $s->bindValue(':email', $_SESSION['email']);
        $s->execute();
    } catch (Exception $ex) {
        $error = 'Error fetching all the joke of user' . $ex->getMessage();
        include 'error.html.php';
        exit();
    }
    foreach ($s as $row) {
        $jokes[] = array('id' => $row['id'], 'text' => $row['joketext'], 'jokedate' => $row['jokedate'], 'username' => $row['name']);
    }
    include 'user/userhome.html.php';
    exit();
}




include $_SERVER['DOCUMENT_ROOT'] . '/letsjoke1/includes/db.inc.php';
try {
    $sql = 'select joke.id, joketext, jokedate, author.name as name from joke
inner join author on authorid = author.id
where author.email = :email
order by jokedate desc';
    $s = $pdo->prepare($sql);
    $s->bindValue(':email', $_SESSION['email']);
    $s->execute();
} catch (Exception $ex) {
    $error = 'Error fetching the joke of user' . $ex->getMessage();
    include 'error.html.php';
    exit();
}
foreach ($s as $row) {
    $jokes[] = array('id' => $row['id'], 'text' => $row['joketext'], 'jokedate' => $row['jokedate'], 'username' => $row['name']);
}
try {
    $sql = 'select j.rate, j.id as jokeid, fa.id, fa.name, joketext, jokedate, author.name as authorname from friendship
inner join author on userid = author.id
inner join joke as j on friendid = j.authorid
inner join author as fa on friendid = fa.id
where author.email = :email';
    $s = $pdo->prepare($sql);
    $s->bindValue(':email', $_SESSION['email']);
    $s->execute();
} catch (Exception $ex) {
    $error = 'Error fetching jokes of friends.' . $ex->getMessage();
    include 'error.html.php';
    exit();
}
foreach ($s as $row) {
    $friends[] = array('name' => $row['name'], 'text' => $row['joketext'],
        'id' => $row['id'], 'jokeid' => $row['jokeid'], 'jokedate' => $row['jokedate'], 'authorname' => $row['authorname']);
}
if (isset($_GET['viewtop'])) {
    include $_SERVER['DOCUMENT_ROOT'] . '/letsjoke1/includes/db.inc.php';

    try {
        $sql = 'select authorid, joke.id as jokeid, joketext, name, jokedate from joke
inner join author on authorid = author.id
order by rate desc
limit 10';
        $s = $pdo->query($sql);
        $s->execute();
    } catch (Exception $ex) {
        $error = 'Error fetching top jokes.';
        include 'error.html.php';
        exit();
    }
    foreach ($s as $row) {
        $tops[] = array('name' => $row['name'], 'text' => $row['joketext'],
            'jokeid' => $row['jokeid'], 'authorid' => $row['authorid'], 'jokedate' => $row['jokedate']);
    }

    include 'user/topjokes.html.php';
    exit();
}
if (isset($_GET['viewlatest'])) {
    include $_SERVER['DOCUMENT_ROOT'] . '/letsjoke1/includes/db.inc.php';

    try {
        $sql = 'select authorid, joke.id as jokeid, joketext, name, jokedate from joke
inner join author on authorid = author.id
order by jokedate desc';
        $s = $pdo->query($sql);
        $s->execute();
    } catch (Exception $ex) {
        $error = 'Error fetching latest jokes.';
        include 'error.html.php';
        exit();
    }

    foreach ($s as $row) {
        $latests[] = array('name' => $row['name'], 'text' => $row['joketext'],
            'jokeid' => $row['jokeid'], 'authorid' => $row['authorid'], 'jokedate' => $row['jokedate']);
    }

    include 'user/latejokes.html.php';
    exit();
}


if (isset($_GET['action']) and $_GET['action'] == 'search-t') {
    include $_SERVER['DOCUMENT_ROOT'] . '/letsjoke1/includes/db.inc.php';

    $select = 'SELECT jokedate, id, joketext';
    $from = ' FROM joke';
    $where = ' WHERE TRUE';
    $order = ' ORDER BY jokedate DESC';

    $placeholders = array();


    if ($_GET['text'] != '') {
        $where .= " AND joketext LIKE :joketext";
        $placeholders[':joketext'] = '%' . $_GET['text'] . '%';
    }

    try {
        $sql = $select . $from . $where . $order;
        $s = $pdo->prepare($sql);
        $s->execute($placeholders);
    } catch (Exception $ex) {
        $error = 'Error fetchin jokes for searching.';
        include 'error.html.php';
        exit();
    }

    foreach ($s as $row) {
        $jokes[] = array('id' => $row['id'], 'text' => $row['joketext'],
            'date' => $row['jokedate'], 'authorid' => $row['authorid']);
    }

    include 'user/seachresult.html.php';
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/letsjoke1/includes/db.inc.php';
include 'user/index.html.php';
