<?php include(__DIR__ . '/../partials/header.php') ?>
<?php include(__DIR__ . '/../partials/navbar.php') ?>

<div class="row">
    <div class="col-sm-4 col-sm-offset-4">
        <div class="panel">
            <div class="panel-heading">
                <h2 class="text-center">Register</h2>

                <form class="" action="/register" method="post">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control"  name="username" placeholder="Username...">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control"  name="password" placeholder="Password...">
                    </div>
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control"  name="first_name" placeholder="First name...">
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control"  name="last_name" placeholder="Last name...">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control"  name="email" placeholder="Email...">
                    </div>
                    <input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign Up">
                </form>
            </div>
            <div class="panel-body">
                <?php flashMessage('warning') ?>
                <p class="text-center" >
                    <a href="/login">Have an account?</a>
                </p>
            </div>
        </div>
    </div>
</div>


<?php include(__DIR__ . '/../partials/footer.php') ?>
