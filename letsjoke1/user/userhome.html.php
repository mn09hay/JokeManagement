<?php
include_once $_SERVER['DOCUMENT_ROOT'] .
        '/letsjoke1/includes/helpers.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Let's Joke</title>
        <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            body{
                padding-top: 80px;
                padding-bottom: 60px;
                padding-left:60px;
                padding-right: 60px;
            }
        </style>
    </head>
    <body>
        <!-- Fixed navbar-->
        <div class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="?">Let's Joke</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="?">Home</a></li>
                        <li><a href="team">Team</a></li>
                        <li><a href="contact">Contact</a></li>
                    </ul>
                    <form action="" method="post" class="navbar-form navbar-right">
                        <div>
                            <input type="hidden" name="action" value="logout">
                            <input type="hidden" name="goto" value="/letsjoke1/">
                            <input type="submit" value="Log out" class="btn btn-primary">
                        </div>
                    </form>
                    <form class="navbar-form navbar-right" role="search" action="" method="get">
                        <div class="form-group">
                            <input type="text" class="form-control" name="text" placeholder="Search For Jokes">
                        </div>
                        <input type="hidden" name="action" value="search-t">
                        <input type="submit" class="btn btn-primary" value="Search">
                        <a href="#myModal" role="button" data-toggle="modal">Advance Search</a>
                    </form>
                </div><!--/.nav-collapse -->
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Advance Search</h4>
                    </div>
                    <div class="modal-body">
                        <form action="" method="get">
                            <p>View jokes satisfying the following criteria:</p>
                            <div>
                                <label for="friend">By author:</label>
                                <select name="friend" id="friend" class="form-control">
                                    <option value="">Any friend</option>
                                    <?php foreach ($friends as $friend): ?>
                                        <option value="<?php htmlout($friend['id']); ?>"><?php htmlout($friend['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label for="category">By category:</label>
                                <select name="category" id="category" class="form-control">
                                    <option value="">Any category</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php htmlout($category['id']); ?>"><?php htmlout($category['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label for="text">Containing text:</label>

                                <input type="text" name="text" id="text" class="form-control">
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="action" value="search">
                                <input type="submit" class="btn btn-primary" value="Search">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="col-md-2 col-md-offset-1" sidebar>
                <div class="row">
                    <div class="col-md-5">
                        <img style="width: 80px;" src="<?php htmlout($path); ?>" class="img-rounded">
                    </div>
                    <div class="col-md-7">
                        <br/>
                        <br/>
                        <br/>
                        <a href="#" class="pull-right"><?php htmlout($username); ?></a>
                    </div>
                </div>
                <br/>
                <br/>
                <div class="row">
                    <div>
                        <ul class="nav nav-pills nav-stacked">
                            <li class="active"><a href="?">News Feed<span class="badge pull-right">42</span></a></li>
                            <li><a href="?viewtop">Top Jokes</a></li>
                            <li><a href="?viewlatest">Top Jokers</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-7 col-md-offset-1">

                <div class="container-fluid">
                    <?php if (isset($jokes)): ?>
                        <?php foreach ($jokes as $joke): ?>
                            <div class="row">
                                <div class="well">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="col-md-4">
                                                    <?php
                                                    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
                                                    $fid = $joke['username'];
                                                    try {
                                                        $sql = 'select path from author where name = :name';
                                                        $s = $pdo->prepare($sql);
                                                        $s->bindValue(':name', $fid);
                                                        $s->execute();
                                                    } catch (Exception $ex) {
                                                        $error = "Error fetching friend path";
                                                        include 'error.html.php';
                                                        exit();
                                                    }
                                                    foreach ($s as $result) {
                                                        $path = $result['path'];
                                                    }
                                                    ?>
                                                    <img style="width: 60px;" src="<?php htmlout($path); ?>" class="img-rounded  pull-left">
                                                </div>
                                                <div class="col-md-8">
                                                    <br/>
                                                    <a href="#"><?php htmlout($joke['username']); ?></a>
                                                    <p class="text-muted"><?php htmlout($joke['jokedate']); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <p style="background-color: white" class="pull-left"><?php htmlout($joke['text']); ?> </p>

                                        </div>
                                        <div class="row">
                                            <form action="?" method="post">
                                                <div>
                                                    <input type="hidden" name="id" value="<?php htmlout($joke['id']); ?>">
                                                    <input type="submit" name="action" value="Delete" class="btn btn-primary btn-sm pull-right">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-md-offset-2">
                                <ul class="pagination">
                                    <li><a href="#">&laquo;</a></li>
                                    <li><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">4</a></li>
                                    <li><a href="#">5</a></li>
                                    <li><a href="#">&raquo;</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>