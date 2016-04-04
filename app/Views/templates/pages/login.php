<div class="row">
    <div class="col-sm-4 col-sm-offset-4">
        <div class="panel">
            <div class="panel-heading">
                <h2 class="text-center">Login</h2>

                <form class="" action="/login" method="post">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control"  name="username" placeholder="Username...">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control"  name="password" placeholder="Password...">
                    </div>
                    <input class="btn btn-primary btn-lg btn-block" type="submit" name="name" value="Login">
                </form>
            </div>
            <div class="panel-body">
                <?php flashMessage('warning') ?>
                <p class="text-center" >
                    <a href="/register">Need an account?</a>
                </p>
            </div>
        </div>
    </div>
</div>
