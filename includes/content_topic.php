        <div id="container">
            <div id="content">
                <h2><?php echo $controller->getValue('topic_title'); ?></h2>

                <?php 
                    if(isset($_SESSION['user_data'])) :
                ?>
                    <a id="new-message" href="forum.php?page=new_comment&topic_id=<?php echo $controller->getValue('topic_id'); ?>">Új hozzászólás</a>
                <?php        
                    endif;
                ?>
                <?php foreach($controller->getValue("comment_rows") as $row) {
                        echo '<div class="comment">';
                        echo '    <div class="comment-profile"><img src="upload/' . $row['image_name'] . '" width="100" height="100"/></div>';
                        echo '    <div class="comment-header">' . $row['user_name'] . ' | ' . $row['create_date'] . ' | Lájk: ' . $row['liked'] .  
                        ' | <a href="forum.php?page=like&topic_id=' . $controller->getValue('topic_id') . '&comment_id=' . $row['id'] . '">Én is lájkolom!</a></div>';
                        echo '    <div class="comment-body">' . $row['content'] . '</div>';
                        echo '</div>';
                    }
                ?>
            </div>
        <div id="menu">
            <?php 
                    if(isset($_SESSION['user_data'])) {
                        echo 'Üdv, ' . $_SESSION['user_data']['name'] . '!';
                    }
                ?>
        	<ul>
                <?php 
                    if(!isset($_SESSION['user_data'])) :
                ?>
                    <li><a href="forum.php?page=login">Bejelentkezés</a></li>
                    <li><a href="forum.php?page=registration">Regisztráció</a></li>
                <?php        
                    endif;
                ?>
                <li><a href="forum.php?page=topics">Fórum</a></li>               
                <?php 
                    if(isset($_SESSION['user_data'])) :
                ?>
                    <li><a href="forum.php?page=logout">Kijelentkezés</a></li>
                <?php        
                    endif;
                ?>
            </ul>
        </div>
        </div>             
