<nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin-bottom: 2em;">
    <div class="container-fluid">

        <a class="navbar-brand" href="/">Code Crunchers!</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="container">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/scores">Global Rankings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/help">Help & Support</a>
                </li>
                <?php
                //Hide if the user is not logged in
                //TODO replace temp variable with proper login check
                use app\core\Gate;

                if(isset($loggedIn) && $loggedIn = true){
                    echo '
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        My Account
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Download</a></li>
                        <li><a class="dropdown-item" href="#">My Account</a></li>
                        <li><a class="dropdown-item" href="#">My HighScores</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Logout</a></li>
                    </ul>
                </li>
                ';}?>

            </ul>

            <?php

            if(Gate::loggedIn()){
                echo '<a href="/account"><button class="btn btn-primary">My Account</button></a>';
            }else{
                echo '<a href="/login"><button class="btn btn-primary">Login!</button></a>';

            }

            ?>
        </div>
        </div>
    </div>
</nav>