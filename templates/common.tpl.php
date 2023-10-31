<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../classes/class.user.php');
    require_once(__DIR__ . '/../classes/class.session.php');
    require_once(__DIR__ . '/../database/database.connection.php');

function drawLogReg() { ?>
        <div class="wrapper">
        <section id="logo">
            <h1>Trouble Ticket<br>Management</h1>
            <h3><em>We manage your tickets</em></h3>
        </section> <?php 
}

function drawHead() { ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="../css/style.css">
        <script src="../javascript/script.js" defer></script>
        <script src="../javascript/filters.js" defer></script>
        <script src="../javascript/filtersA.js" defer></script>
        <script src="../javascript/filtersU.js" defer></script>
        <script src="../javascript/tickets.js" defer></script>
        <script src="../javascript/editAdmin.js"defer></script>
        <script src="../javascript/messages.js"defer></script>
        <script src="../javascript/filtersAll.js"defer></script>
       
        <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    </head>
    <body>
    <wrapper><?php
}

function drawLoginForm() { ?>

    <section id="loginform">
        <form action="../actions/action.login.php" method="post">
            <label>
                <img src="/images/profile.svg" alt="profile icon">
                <input type="text" name="username" placeholder="Username" value="<?=htmlentities($_SESSION['input']['username login'])?>">
            </label>
            <label>
                <img src="/images/lock.svg" alt="profile icon">
                <input type="password" name="password" placeholder="Password" value="<?=htmlentities($_SESSION['input']['password login'])?>">
            </label>
            <input id="button" type="submit" value="Log In">
            
            <h4>Don't have an account yet? <a href="../pages/register.php">Register</a></h4>
        </form>
    </section>
    </div> <?php
}
function drawRegisterForm() { ?>

    <section id="registerform">
        <form action="../actions/action.register.php" method="post">
            <label>
                <img src="/images/profile.svg" alt="profile icon">
                <input type="text" name = "name" placeholder="Name" required="required" value="<?=htmlentities($_SESSION['input']['name register'])?>">
            </label>
            <label>
                <img src="/images/profile.svg" alt="profile icon">
                <input type="text" name="username" placeholder="Username" required="required" value="<?=htmlentities($_SESSION['input']['username register'])?>">
            </label>
            <label>
                <img src="/images/email.svg" alt="email icon">
                <input type="email" name="email" placeholder="Email" required="required" value="<?=htmlentities($_SESSION['input']['email register'])?>">
            </label>
            <label>
                <img src="/images/lock.svg" alt="lock icon">
                <input type="password" name="password" placeholder="Password" required="required" value="<?=htmlentities($_SESSION['input']['password register'])?>">
            </label>
            <label>
                <img src="/images/lock.svg" alt="lock icon">
                <input type="password" name="confirm_password" placeholder="Confirm Password" required="required" value="<?=htmlentities($_SESSION['input']['confirm_password register'])?>">
            </label>
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            <input id="button" type="submit" value="Register">
            
            <h4>Already have an account? <a href="../pages/login.php">Log In</a></h4>
        </form>
    </section>
</div> <?php
}

function drawFooter() { ?>
        </wrapper>
        <footer>
            <h3>Ticket Manager</h3>
            <div class="social"> 
                <a href="https://www.instagram.com" target="_blank"><img src="../images/instagram_logo.svg" alt=""></a>
                <a href="https://www.facebook.com" target="_blank"><img src="../images/facebook_logo.svg" alt=""></a>
            </div>
            <h4>Ticket Manager All Rights Reserved</h4>
        </footer>
    </body>
</html> <?php
}
function drawSideBar(User $user){ ?>
    <aside class="sidebar">
            
        <div class="sidebar-top">
            <div id="user">
                <img id="user_image"src="/images/userimage.jpg" alt="user image">
                <h2><?=htmlentities($user->name)?></h2>
                <h2><?=htmlentities($user->role)?></h2>
            </div>

            <a class="new-ticket-button" href="../pages/newticket.php">
                <div id="new_ticket">
                    <img id="new_ticket_image" src="/images/new_ticket.png" alt="user image">
                    <p>New Ticket</p>
                </div>
            </a>
            <div class="nav-menu">
                <ul>
                    <li><a href="../pages/profile.php">Profile</a></li>
                    <li><a href="../pages/tickets.php">Tickets</a></li>
                    <li><a href="../pages/faqs.php">FAQS</a></li>
                </ul> 
            </div>
        </div>    
        <div class="logout">
            <p id="logout"><a href="../actions/action.logout.php">Logout</a></p>
        </div>
    </aside> <?php
}

function drawSideBarAgent(User $user){ ?>
    <aside class="sidebar">
            
        <div class="sidebar-top">
            <div id="user">
                <img id="user_image"src="/images/userimage.jpg" alt="user image">
                <h2><?=htmlentities($user->name)?></h2>
                <h2><?=htmlentities($user->role)?></h2>
            </div>
        </div>

        <a class="new-ticket-button" href="../pages/newticket.php">
                <div id="new_ticket">
                    <img id="new_ticket_image" src="/images/new_ticket.png" alt="user image">
                    <p>New Ticket</p>
                </div>
        </a>

        <div class="nav-menu">
            <ul>
                <li><a href="../pages/profile.php">Profile</a></li>
                <li><a href="../pages/tickets.php">Tickets</a></li>
                <li><a href="../pages/tickets_assigned.php">My Tickets</a></li>
                <li><a href="../pages/faqs.php">FAQS</a></li>
           </ul> 
        </div>   
        <div class="logout">
            <p id="logout"><a href="../actions/action.logout.php">Logout</a></p>
        </div>
            </aside> <?php
}
function drawSideBarAdmin(User $user){ ?>
    <aside class="sidebar">
            
        <div class="sidebar-top">
            <div id="user">
                <img id="user_image"src="/images/userimage.jpg" alt="user image">
                <h2><?=htmlentities($user->name)?></h2>
                <h2><?=htmlentities($user->role)?></h2>
            </div>
        </div>

        <div class="nav-menu">
            <ul>
                <li><a href="../pages/profile.php">Profile</a></li>
                <li><a href="../pages/tickets_all.php">Tickets</a></li>
                <li><a href="../pages/faqs.php">FAQS</a></li>
                <li><a href="../pages/list_users.php">List Users</a></li>
                <li><a href="../pages/controlsystem.php">System</a></li>
           </ul> 
        </div>   
        <div class="logout">
            <p id="logout"><a href="../actions/action.logout.php">Logout</a></p>
        </div>
            </aside> <?php
}
function drawLogout(Session $session) { ?>
    <form action="../actions/action_logout.php" method="post" class="logout">
      <button type="submit">Logout</button>
    </form>
<?php }

function drawMessages(Session $session) { ?>
    <section id="messages">
        <?php foreach($session->getMessages() as $message) { ?>
            <article clas="<?=$message['type']?>">
            <i class="fas fa-exclamation-circle"></i>
            <?=$message['text']?>
            </article>
        <?php } ?>
    </section>
<?php }