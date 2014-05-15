<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Let's Joke</title>
        <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
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
                padding-left: 60px;
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
                    <a class="navbar-brand" href="#">Let's Joke</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="team">Team</a></li>
                        <li><a href="contact">Contact</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>
        <!-- Main Content -->
        <div class="container-fluid">
            <div class="row">
                <!-- Carousel -->
                <div class="col-md-8">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                        </ol>
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">
                            <div class="item active">
                                <img src="joke1.jpg" class="img-responsive" alt="slide1">
                                <div class="carousel-caption">

                                </div>
                            </div>
                            <div class="item">
                                <img src="joke2.jpg" class="img-responsive" alt="Second slide">
                                <div class="container">
                                    <div class="carousel-caption">

                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <img src="joke3.jpg" class="img-responsive" alt="Third slide">
                                <div class="container">
                                    <div class="carousel-caption">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Controls -->
                        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                    </div>
                </div>
                <!-- Sign in and sign up module -->
                <div class="col-md-4">
                    <!-- Sign in module -->
                    <form class="form-horizontal" role="form" action="" method="post">
                        <legend>Welcome to Let's Joke</legend>
                        <div class="form-group">

                            <div class="col-sm-10">
                                <input type="text" name="email" class="form-control" id="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">

                            <div class="col-sm-10">
                                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"> Remember me
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10">
                                <input type="hidden" name="action" value="login">
                                <button type="submit" class="btn btn btn-primary btn-lg">Sign in</button>
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal" role="form" action="" method="post">
                        <legend>New to Let's Joke?</legend>
                        <div class="form-group">

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputUsername" name ="name" placeholder="User Name">
                            </div>
                        </div>
                        <div class="form-group">

                            <div class="col-sm-10">
                                <input type="text" name="Remail" class="form-control"  placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">

                            <div class="col-sm-10">

                                <input type="password" class="form-control" id="Rpassword" name="Rpassword" placeholder="Password">

                            </div>
                        </div>
                        <div class="form-group">

                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="Rrepassword" name="Rrepassword" placeholder="Retype Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10">
                                <input type="hidden" name="action" value="register">
                                <input type="submit" class="btn btn btn-warning btn-lg" value="Sign Up">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Footer-->
        <div class="navbar navbar-fixed-bottom">
            <div class="col-md-4 col-md-offset-5">
                <div class="container">
                    <p class="text-muted">Copyright &#169; Letsjoke.com, All Rights Reserved.</p>
                </div>
            </div>
        </div>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>