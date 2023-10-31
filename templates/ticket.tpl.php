<?php
 declare(strict_types = 1);
 require_once(dirname(__DIR__).'/classes/class.department.php');
 require_once(dirname(__DIR__).'/classes/class.ticket.php');
 function drawTicket_new(Ticket $ticket, string $department_name, array $comments,User $ticket_creator,?User $assigned, $assinged_to, array $hashtags, array $agents){?>

    <div id="ticket">
        <div class="ticket-top">
            <h1><?=htmlentities($ticket->title)?></h1>
        </div>

        <div class="ticket-wrapper">
            <div id="description">
                <h2> Description </h2>
                <p> <?=htmlentities($ticket->description)?></p>
            </div>
            
            <div id="ticket_info">
            
                <ul>
                    <li><span>Ticket id </span> <span class="info"><?=$ticket->ticket_id?></span></li>
                    
                    <li><span>Creator </span> <span class="info"><?=htmlentities($ticket_creator->name)?></span> </li>
                    <li><span>Creation Date </span> <span class="info"><?=$ticket->date->format("Y-m-d H:i")?></span> </li>
                    <li><span>Status </span> <span class="info"><?=htmlentities($ticket->status)?></span> </li>
                    <li><span>Priority </span> <span class="info"><?=htmlentities($ticket->priority)?></span></li>
                    <li><span>Department </span> <span class="info"><?=htmlentities($department_name) ?></span></li>
                    
                    <li><span>Hashtags </span> 
                        <?php foreach ($hashtags as $hashtag) {  ?>
                        
                        <span class="info" class="hashtag" id=<?=$hashtag["hashtag_id"]?> > <?=$hashtag["name"]?> </span>
                                
                        <?php } ?>
                    </li>
                    <li><span>Agent: </span>  <span class="info"><?= $ticket->assigned_to !== 0 ? $assinged_to : 'Not Assigned' ?></span></li>
                </ul>
            
                <div class="ticket-buttons">
                    <div class="edit-ticket-button1">
                        <?php if ($assigned->role == "agent" || $assigned->role =="admin") { ?> 
                            <button id="edit_ticket">Edit Ticket</button>
                        <?php } ?>
                    </div>
                    <div class="assign-ticket-button">
                    <form action="../actions/action.updateticket.php" method="post" id="department-form">
                        <input type="hidden" name="ticket_id" value="<?= $ticket->ticket_id ?>">
                        <select name="user_id" onchange="this.form.submit()">
                            <option value="" disabled selected>Assign To</option>
                            <?php foreach($agents as $agent) { ?>
                                <option name="user_id" value="<?= $agent->id ?>"><?= $agent->name ?></option>
                            <?php } ?>
                        </select>
                        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                    </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="comments">
            <p id="title">Comments</p>

        <!--<form method="POST" id="post_comment" action="/../actions/action.postcomment.php">-->
        <form id="post_comment">
            <label for="comment"></label>
                <textarea id="post_comment_text" name="comment" required placeholder="Typer your comment here....."></textarea> 
                <input type="hidden" id="comment_user_id" name="comment_user_id" value=<?= $assigned->id?>>
                <input type="hidden" id="comment_ticket_id" name="comment_ticket_id" value=<?=$ticket->ticket_id?>>
                <button type="submit" id="post_comment_button">Submit</button>
            </form>

            <?php foreach($comments as $comment) { ?>
                <div id="comment">
                    <div id="user_info">
                        <img id="user_image"src="/images/userimage.jpg" alt="user image">
                        <p id="username"><?= htmlentities($comment["name"]) ?></p>
                        <p id="date"><?= htmlentities($comment["date"]) ?></p>
                    </div>
                    <p><?= htmlentities($comment["description"]) ?> </p>
                </div>
            <?php } ?>
        </div>


    </div>


<?php } 
function drawTicket_new_User(Ticket $ticket, string $department_name, array $comments, ?User $agent, ?User $user,array $hashtags) {?>

    <div id="ticket">
        <h1><?=htmlentities($ticket->title)?></h1>

        <div class="ticket-wrapper">
            <div id="description">
                <h2> Description </h2>
                <p> <?=htmlentities($ticket->description)?></p>
            </div>
            
            <div id="ticket_info">
            
                <ul>
                    <li><span>Ticket id </span> <span class="info"><?=$ticket->ticket_id?></span></li>
                    <li><span>Agent: </span>  <span class="info"><?= ($agent !== null) ? htmlentities($agent->name) : "Not assigned" ?></span></li>
                    <li><span>Creation Date </span> <span class="info"><?=$ticket->date->format("Y-m-d H:i")?></span> </li>
                    <li><span>Status </span> <span class="info"><?=htmlentities($ticket->status)?></span> </li>
                    <li><span>Priority </span> <span class="info"><?=htmlentities($ticket->priority)?></span></li>
                    <li><span>Department </span> <span class="info"><?=htmlentities($department_name) ?></span></li>
                    
                    <li><span>Hashtags </span> 
                        <?php foreach ($hashtags as $hashtag) {  ?>
                        
                        <span class="info" class="hashtag" id=<?=$hashtag["hashtag_id"]?> > <?=$hashtag["name"]?> </span>
                                
                        <?php } ?>
                    </li>
                </ul>
            
                <?php if ($user->role == "agent" || $user->role =="admin") { ?> 
                    <button id="edit_ticket">Edit Ticket</button>
                <?php } ?>
            </div>
        </div>

        <div id="comments">
            <p id="title">Comments</p>

        <form id="post_comment">
            <label for="comment"></label>
                <textarea id="post_comment_text" name="comment" required placeholder="Typer your comment here....."></textarea> 
                <input type="hidden" id="comment_user_id"name="comment_user_id" value=<?=$user->id?>>
                <input type="hidden" id="comment_ticket_id" name="comment_ticket_id" value=<?=$ticket->ticket_id?>>
                <button type="submit" id="post_comment_button">Submit</button>
        </form>

            <?php foreach($comments as $comment) { ?>
                <div id="comment">
                    <div id="user_info">
                        <img id="user_image"src="/images/userimage.jpg" alt="user image">
                        <p id="username"><?= htmlentities($comment["name"]) ?></p>
                        <p id="date"><?= htmlentities($comment["date"]) ?></p>
                    </div>
                    <p><?= htmlentities($comment["description"]) ?> </p>
                </div>
            <?php } ?>
        </div>


    </div>


<?php } 

function drawNewTicket(User $user, array $departments) { ?>
    <section id="new-ticket">
        <div class="new-ticket-form">
            <h2>Create a New Ticket</h2>
            <form action="../actions/action.newticket.php" method="post">
                <label>
                    Title: <input type="text" name="title" required="required">
                </label>
                <label>
                    Description: <textarea name="description" required="required"></textarea>
                </label>
                <div class="new-ticket-form-options">
                    <select name="department">
                        <option value="" disabled selected hidden>Department</option>
                        <?php foreach ($departments as $department) { ?>
                            <option value="<?php echo $department['department_id']; ?>"><?php echo $department['department_name']; ?></option>
                        <?php } ?>
                    </select>
                    <select name="priority">
                        <option value="" disabled selected hidden>Priority</option>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                    </select>
                </div>
                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                <button type="submit" name="update_user">Submit</button>
            </form>
        </div>
        <div class="new-ticket-right">
            <img src="../images/ticket.svg" alt="">
            <p>We will assign your ticket to one of our agents as soon as possible</p>
        </div>
    </section>
<?php }

function drawTickets(PDO $db, array $tickets) { ?>
    <section id="tickets">
        <header class="titles">
            <a href="menu.html"><h2>Tickets</h2></a>
            <div class="tickets-forms">
                <form action="" method="get" id="department-form">
                    <select name="Department">
                        <option value="" disabled selected>Department</option>
                        <?php
                        $uniqueDepartments = array_column(Department::getDepartments($db), 'department_name');
                        foreach($uniqueDepartments as $department) {
                        ?>
                        <option value="<?= $department ?>"> <?= $department ?></option>
                        <?php } ?>
                    </select>
                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                </form>
                <form action="" method="get" id="date-form">
                    <select name="Date">
                        <option value="" disabled selected>Date</option>
                        <?php
                        $uniqueDates = array_unique(array_column($tickets, 'date'));
                        foreach($uniqueDates as $date) { ?>
                        <option value=<?= $date ?>><?= $date ?></option>
                        <?php } ?>
                    </select>
                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                </form>
                <form action="" method="get" id="status-form">
                    <select name="Status">
                        <option value="" disabled selected>Status</option>
                        <option value= "">All</option>
                        <?php $statuses = Ticket::$Statuses;
                            foreach($statuses as $status) { ?>
                            <option value="<?= $status ?>"><?= $status ?></option>
                            <?php } ?>
                    </select>
                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                </form>
                <form action="" method="get" id="priority-form">
                    <select name="Priority">
                        <option value="" disabled selected>Priority</option>
                        <option value="All">All</option>
                        <?php $priorities = Ticket::$Priorities;
                            foreach($priorities as $priority) { ?>
                            <option value="<?= $priority ?>"><?= $priority ?></option>
                            <?php } ?>
                    </select>
                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                </form>
            </div>
        </header>

        <div class="tickets-info">
            <table class="tickets-table" id="tickets-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Department</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Open</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($tickets as $ticket) {
                        $ticket_id = intval($ticket['ticket_id']);
                        $title = $ticket['title'];
                        $department_name = $ticket['department_name'];
                        $date= $ticket['date'];
                        $status= $ticket['status'];
                        $priority= $ticket['priority'];
                        ?>
                        <tr>
                            <td><?= $title ?></td>
                            <td><?= $department_name ?></td>
                            <td><?= $date ?></td>
                            <td><?= $status ?></td>
                            <td><?= $priority ?></td>
                            <td>
                            <form class="view-ticket-form" method="get">
                                <input type="hidden" name="id" value="<?= $ticket_id ?>">
                                <button type="submit">View Ticket</button>
                                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                            </form>
                            </td>
                        </tr>
                    <?php } ?>  
                </tbody>
            </table>
        </div>
        
    </section> 
<?php }

    function drawAssignedTickets(PDO $db, array $tickets, int $user_id) { ?>
        <section id="tickets">
            <header class="titles">
                <a href="menu.html"><h2>Tickets</h2></a>
                <div class="tickets-forms">
                    <form action="" method="get" id="department-formA">
                        <input type="hidden" name="userId" value="<?= $user_id ?>">
                        <select name="Department">
                            <option value="" disabled selected>Department</option>
                            <?php
                            $uniqueDepartments = array_column(Department::getDepartments($db), 'department_name');
                            foreach($uniqueDepartments as $department) {
                            ?>
                            <option value="<?= $department ?>"> <?= $department ?></option>
                            <?php } ?>
                        </select>
                        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                    </form>
                    <form action="" method="get" id="user-formA">
                        <input type="hidden" name="userId" value="<?= $user_id ?>">
                        <select name="User">
                            <option value="" disabled selected>User</option>
                            <?php
                            foreach($tickets as $ticket){
                                $users[] = User::getUser_name($db, $ticket->getUserId());
                            }
                            $uniqueUsers = array_unique($users);
                            foreach($uniqueUsers as $user) { ?>
                            <option value=<?= $user ?>><?= $user ?></option>
                        <?php } ?>
                        </select>
                        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                    </form>
                    <form action="" method="get" id="status-formA">
                        <input type="hidden" name="userId" value="<?= $user_id ?>">
                        <select name="Status">
                            <option value="" disabled selected>Status</option>
                            <option value= "">All</option>
                            <?php $statuses = Ticket::$Statuses;
                                foreach($statuses as $status) { ?>
                                <option value="<?= $status ?>"><?= $status ?></option>
                                <?php } ?>
                        </select>
                        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                    </form>
                    <form action="" method="get" id="priority-formA">
                        <input type="hidden" name="userId" value="<?= $user_id ?>">
                        <select name="Priority">
                            <option value="" disabled selected>Priority</option>
                            <option value="All">All</option>
                            <?php $priorities = Ticket::$Priorities;
                                foreach($priorities as $priority) { ?>
                                <option value="<?= $priority ?>"><?= $priority ?></option>
                                <?php } ?>
                        </select>
                        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                    </form>
                </div>
            </header>

            <div class="tickets-info">
                <table class="tickets-table" id="tickets-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Creator</th>
                            <th>Department</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Open</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($tickets as $ticket) {
                            $ticket_id = $ticket->getTicketId();
                            $user = User::getUser_name($db, $ticket->getUserId());
                            $title = $ticket->getTicketTitle();
                            $department_name = Department::getDepartmentName($db, $ticket_id);
                            $date = $ticket->getTicketDate()->format('Y-m-d H:i:s');
                            $status = $ticket->getTicketStatus();
                            $priority = $ticket->getTicketPriority();
                            ?>
                            <tr>
                                <td><?= $title ?></td>
                                <td><?= $user ?></td>
                                <td><?= $department_name ?></td>
                                <td><?= $date ?></td>
                                <td><?= $status ?></td>
                                <td><?= $priority ?></td>
                                <td>
                                <form class="view-ticket-form" method="get">
                                    <input type="hidden" name="id" value="<?= $ticket_id ?>">
                                    <button type="submit">View Ticket</button>
                                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                                </form>
                                </td>
                            </tr>
                        <?php } ?>  
                    </tbody>
                </table>
            </div>
            
        </section> 
    <?php }

function drawUnassignedTickets(PDO $db, array $tickets) { ?>
    <section id="tickets">
        <header class="titles">
            <a href="menu.html"><h2>Tickets</h2></a>
            <div class="tickets-forms">
            <form action="" method="get" id="department-formU">
                        <select name="Department">
                            <option value="" disabled selected>Department</option>
                            <?php
                            $uniqueDepartments = array_column(Department::getDepartments($db), 'department_name');
                            foreach($uniqueDepartments as $department) {
                            ?>
                            <option value="<?= $department ?>"> <?= $department ?></option>
                            <?php } ?>
                        </select>
                        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                    </form>
                    <form action="" method="get" id="user-formU">
                        <select name="User">
                            <option value="" disabled selected>User</option>
                            <?php
                            foreach($tickets as $ticket){
                                $users[] = User::getUser_name($db, $ticket->getUserId());
                            }
                            $uniqueUsers = array_unique($users);
                            foreach($uniqueUsers as $user) { ?>
                            <option value=<?= $user ?>><?= $user ?></option>
                        <?php } ?>
                        </select>
                        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                    </form>
                    <form action="" method="get" id="status-formU">
                        <select name="Status">
                            <option value="" disabled selected>Status</option>
                            <option value= "">All</option>
                            <?php $statuses = Ticket::$Statuses;
                                foreach($statuses as $status) { ?>
                                <option value="<?= $status ?>"><?= $status ?></option>
                                <?php } ?>
                        </select>
                        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                    </form>
                    <form action="" method="get" id="priority-formU">
                        <select name="Priority">
                            <option value="" disabled selected>Priority</option>
                            <option value="All">All</option>
                            <?php $priorities = Ticket::$Priorities;
                                foreach($priorities as $priority) { ?>
                                <option value="<?= $priority ?>"><?= $priority ?></option>
                                <?php } ?>
                        </select>
                        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                    </form>
            </div>
        </header>

        <div class="tickets-info">
                <table class="tickets-table" id="tickets-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Creator</th>
                            <th>Department</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Open</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($tickets as $ticket) {
                            $ticket_id = $ticket->getTicketId();
                            $user = User::getUser_name($db, $ticket->getUserId());
                            $title = $ticket->getTicketTitle();
                            $department_name = Department::getDepartmentName($db, $ticket_id);
                            $date = $ticket->getTicketDate()->format('Y-m-d H:i:s');
                            $status = $ticket->getTicketStatus();
                            $priority = $ticket->getTicketPriority();
                            ?>
                            <tr>
                                <td><?= $title ?></td>
                                <td><?= $user ?></td>
                                <td><?= $department_name ?></td>
                                <td><?= $date ?></td>
                                <td><?= $status ?></td>
                                <td><?= $priority ?></td>
                                <td>
                                <form class="view-ticket-form" method="get">
                                    <input type="hidden" name="id" value="<?= $ticket_id ?>">
                                    <button type="submit">View Ticket</button>
                                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                                </form>
                                </td>
                            </tr>
                        <?php } ?>  
                    </tbody>
                </table>
            </div>
        
    </section> 
<?php } 

function drawAllTickets(PDO $db, array $tickets) { ?>
    <section id="tickets">
        <header class="titles">
            <a href="menu.html"><h2>Tickets</h2></a>
            <div class="tickets-forms">
            <form action="" method="get" id="department-formAll">
                        <select name="Department">
                            <option value="" disabled selected>Department</option>
                            <?php
                            $uniqueDepartments = array_column(Department::getDepartments($db), 'department_name');
                            foreach($uniqueDepartments as $department) {
                            ?>
                            <option value="<?= $department ?>"> <?= $department ?></option>
                            <?php } ?>
                        </select>
                        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                    </form>
                    <form action="" method="get" id="user-formAll">
                        <select name="User">
                            <option value="" disabled selected>User</option>
                            <?php
                            foreach($tickets as $ticket){
                                $users[] = User::getUser_name($db, $ticket->getUserId());
                            }
                            $uniqueUsers = array_unique($users);
                            foreach($uniqueUsers as $user) { ?>
                            <option value=<?= $user ?>><?= $user ?></option>
                        <?php } ?>
                        </select>
                        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                    </form>
                    <form action="" method="get" id="status-formAll">
                        <select name="Status">
                            <option value="" disabled selected>Status</option>
                            <option value= "">All</option>
                            <?php $statuses = Ticket::$Statuses;
                                foreach($statuses as $status) { ?>
                                <option value="<?= $status ?>"><?= $status ?></option>
                                <?php } ?>
                        </select>
                        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                    </form>
                    <form action="" method="get" id="priority-formAll">
                        <select name="Priority">
                            <option value="" disabled selected>Priority</option>
                            <option value="All">All</option>
                            <?php $priorities = Ticket::$Priorities;
                                foreach($priorities as $priority) { ?>
                                <option value="<?= $priority ?>"><?= $priority ?></option>
                                <?php } ?>
                        </select>
                        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                    </form>
            </div>
        </header>

        <div class="tickets-info">
            <table class="tickets-table" id="tickets-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Creator</th>
                        <th>Department</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Open</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($tickets as $ticket) {
                         $ticket_id = $ticket->getTicketId();
                         $user = User::getUser_name($db, $ticket->getUserId());
                         $title = $ticket->getTicketTitle();
                         $department_name = Department::getDepartmentName($db, $ticket_id);
                         $date = $ticket->getTicketDate()->format('Y-m-d H:i:s');
                         $status = $ticket->getTicketStatus();
                         $priority = $ticket->getTicketPriority();
                        ?>
                        <tr>
                            <td><?= $title ?></td>
                            <td><?= $user ?></td>
                            <td><?= $department_name ?></td>
                            <td><?= $date ?></td>
                            <td><?= $status ?></td>
                            <td><?= $priority ?></td>
                            <td>
                            <form class="view-ticket-form" method="get">
                                <input type="hidden" name="id" value="<?= $ticket_id ?>">
                                <button type="submit">View Ticket</button>
                                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                            </form>
                            </td>
                        </tr>
                    <?php } ?>  
                </tbody>
            </table>
        </div>
        
    </section> 
<?php } ?>

<?php function drawTicketChanges(array $ticket_changes,User $ticket_creator) { ?>
    <section id="tickets">
        
        <header class="titles">
            <h2>Previous Changes of Ticket with id: <?=$ticket_changes[0]['ticket_id']?></h2>
        </header>

        <div class="tickets-info">
            <table class="tickets-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Creator</th>
                        <th>Department</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Date of Change</th>
                        <th>Assigned To</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($ticket_changes as $ticket_change) {
                        
                         $ticket_id = $ticket_change['ticket_id'];
                         $title = $ticket_change['title'];
                         $user = $ticket_creator->name; 
                         $department_name = Ticket::getDepartmentName($ticket_change['department_id']);
                         $date = $ticket_change['date'];
                         $status = $ticket_change['status'];
                         $priority = $ticket_change['priority'];
                         $date_changed = $ticket_change['change_date'];
                         $assigned_to_name = $ticket_change['assigned_to_name'];
                        ?>
                        <tr>
                            <td><?= $title ?></td>
                            <td><?= $user ?></td>
                            <td><?= $department_name ?></td>
                            <td><?= $date ?></td>
                            <td><?= $status ?></td>
                            <td><?= $priority ?></td>
                            <td><?= $date_changed ?></td>
                            <?php if($assigned_to_name==NULL) { ?>
                                <td> Nobody</td>
                            <?php } else { ?>
                                <td><?=$assigned_to_name ?></td>
                            <?php }?>
                        </tr>
                    <?php } ?>  
                </tbody>
            </table>
        </div>
        
    </section> 
<?php } ?>


<?php function drawSystem(User $user) { ?>
    <section id="new-ticket">
        <div class="System-form">
            <h2>Create a New Ticket</h2>
            <form action="../actions/action.updatesystem.php" method="post" name="new_status">
                <label>
                    New Status: <input type="text" name="status">
                </label>
                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                <button type="submit" id="update_status">Create new Status</button>
            </form>
            <form action="../actions/action.updatesystem.php" method="post" name="new_priority">
                <label>
                    New Priority: <input type="text" name="priority"></textarea>
                </label>
                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                <button type="submit" id="update_priority">Create new Priority</button>
            </form>
            <form action="../actions/action.updatesystem.php" method="post" name="new_department">
                <label>
                    New Department: <input type="text" name="department"></textarea>
                </label>
                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                <button type="submit" id="update_department">Create new Department</button>
            </form>
        </div>
    </section>
<?php } ?>
