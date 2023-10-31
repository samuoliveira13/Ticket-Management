<?php
    declare(strict_types = 1); 
    require_once(dirname(__DIR__).'/database/database.connection.php');
    require_once(dirname(__DIR__).'/classes/class.user.php');   
    require_once(dirname(__DIR__).'/classes/class.department.php');   

function drawProfile(User $user) {
    ?><section id="profile">

        <div class="profile-left">
            <img src="/images/userimage.jpg" alt="">
            <h2><?=$user->name?></h2>
            <h2>@<?=$user->username?></h2>
        </div>
        <div class="profile-right">
            <ul>
                <li>
                    <span>Name</span>
                    <span class="right"><?=$user->name?> </span>
                </li>
                <li>
                    <span>Username</span>
                    <span class="right"><?=$user->username?> </span>
                </li>
                <li>
                    <span>Email</span>
                    <span class="right"><?=$user->email?> </span>
                </li>
                <li>
                    <span>Role</span>
                    <span class="right"><?=$user->role?> </span>
                </li>
            </ul>

            <button class="edit-prof-button"><a href="../pages/edit_profile.php">Edit Profile</a></button>
        </div>

    </section> <?php
}
function drawProfileAgent(User $user) {
    $db = getDatabaseConnection();
    ?><section id="profile">

        <div class="profile-left">
            <img src="/images/userimage.jpg" alt="">
            <h2><?=$user->name?></h2>
            <h2>@<?=$user->username?></h2>
        </div>
        <div class="profile-right">
            <ul>
                <li>
                    <span>Name</span>
                    <span class="right"><?=$user->name?> </span>
                </li>
                <li>
                    <span>Username</span>
                    <span class="right"><?=$user->username?> </span>
                </li>
                <li>
                    <span>Email</span>
                    <span class="right"><?=$user->email?> </span>
                </li>
                <li>
                    <span>Department</span>
                    <span class="right"><?=$user->getDepartmentName($db)?> </span>
                </li>
                <li>
                    <span>Role</span>
                    <span class="right"><?=$user->role?> </span>
                </li>
            </ul>

            <button class="edit-prof-button"><a href="../pages/edit_profile.php">Edit Profile</a></button>
        </div>

    </section> <?php
}

function drawEditProfile(User $user) { ?>
    <section id="edit-profile">
        <form class="edit-profile-form" action="../actions/action.editprofile.php" method="post">
            <input type="hidden" name="user_id" value="<?=$user->id?>">
            <label>
                Name: <input type="text" name ="name" required="required">
            </label>
            <label>
                Username: <input type="text" name="username" required="required">
            </label>
            <label>
                Email: <input type="email" name="email" required="required">
            </label>
            <label>
                Old Password: <input type="password" name="old_password" required="required">
            </label>
            <label>
                New Password: <input type="password" name="new_password" required="required">
            </label>
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            <button type="submit" name="update_user">Update User</button>
        </form>

        <form action="../actions/action.edit_profile.php" method="post" enctype="multipart/form-data">
            <div class="edit-profile-picture">
                <label>Change Picture: <input type="file" name="image"></label>
            </div>
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            <input type="submit" value="Upload">
        </form>
    </section> <?php
}
?>