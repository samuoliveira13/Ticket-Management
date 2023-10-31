<?php 

declare(strict_types = 1);
require_once(dirname(__DIR__). '/classes/class.department.php');
require_once(dirname(__DIR__) . '/classes/class.user.php');
require_once(dirname(__DIR__) . '/classes/class.session.php');
require_once(dirname(__DIR__) . '/database/database.connection.php');

function drawAllUsers(PDO $db, array $users, int $current_user) { ?>
    <section id="tickets">
        <header class="titles">
            <a href="menu.html"><h2>Tickets</h2></a>
        </header>

        <div class="tickets-info">
            <table class="tickets-table">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $user) {
                        ?>
                        <tr>
                            <td><?= $user->username ?></td>
                            <td><?= $user->email ?></td>
                            <?php if ($user->role === "user" || $user->role === "admin") { ?>
                            <td><?= $user->getDepartmentName($db) ?></td>
                            <?php } else { ?>
                                <td>    
                                    <form action="../actions/action.editadmin.php" method="post" id="department-form<?=$user->id?>" class="department-form">
                                        <input type="hidden" name="userId" value="<?= $user->id ?>">
                                        <select name="department_id">
                                            <option value="" selected><?= $user->getDepartmentName($db) ?></option>
                                            <?php 
                                            $departments = Department::getDepartments($db);
                                            $uniqueDepartments = array_unique(array_column($departments, 'department_name'));
                                            $uniqueDepartments = array_diff($uniqueDepartments, [$user->getDepartmentName($db)]);
                                            foreach($uniqueDepartments as $department) { ?>
                                                <option value=<?= $department ?>><?= $department ?></option>
                                            <?php } ?> 
                                        </select>
                                        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                                    </form>
                                </td>
                            <?php } ?>
                            <?php if($current_user == $user->id) {?>
                                <td><?= $user->role ?></td>
                            <?php } else {?>    
                            <td>
                            <form action="../actions/action.editadmin.php" method="post" id="role-form<?=$user->id?>" class="role-form">
                                    <input type="hidden" name="userId" value="<?= $user->id ?>">
                                    <select name="role">
                                        <option value="" selected><?= $user->role ?></option>
                                            <?php 
                                                $uniqueRoles = ['user', 'agent', 'admin'];
                                                $uniqueRoles = array_diff($uniqueRoles, [$user->role]);
                                                foreach($uniqueRoles as $role) { ?>
                                                    <option value=<?= $role ?>><?= $role ?></option>
                                            <?php } ?> 
                                    </select>
                                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                            </form>
                            </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>  
                </tbody>
            </table>
        </div>
        
    </section> 
<?php } ?>