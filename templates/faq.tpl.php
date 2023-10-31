<?php
 declare(strict_types = 1); 

 ?>

<?php

require_once(dirname(__DIR__).'/templates/faq.tpl.php');

?>


<?php function drawFAQS($faqs,$user) { ?>

    <div class="faqs">
    
        <div class="faq_title">
            <h1>Frequently asked questions</h1>
            <img src="..\images\messagequestion.png" alt="faq image">
        </div>

        <?php if ($user->role == "agent" || $user->role =="admin") { ?> 
            <form id="post_faq" action="../actions/action.postfaq.php" method="post">
                <label for="faq"></label>
                    <textarea id="post_faq_question" name="post_faq_question" required placeholder="Add FAQ Question here....."></textarea>
                    <textarea id="post_faq_answer" name="post_faq_answer" required placeholder="Add FAQ Answer here....."></textarea>  
                    <button type="submit" id="post_faq_button">Submit</button>
            </form>
        <?php } ?>

    <?php foreach($faqs as $faq){?>
            <div class="faq">
                <div class="question"><?= htmlentities($faq->question)?></div>
                <div class="answer"><?= htmlentities($faq->answer)?></div>

                <?php if ($user->role == "agent" || $user->role =="admin") { ?> 
                    <?php } ?>
            </div>
        <?php }?>

   </div>

<?php } ?>