        <div id="container">
            <div id="content">
                <?php 
                    if(isset($_SESSION['user_data'])) :
                ?>
                    <a href="forum.php?page=new_comment&topic_id=<?php echo $controller->getValue('topic_id'); ?>">Új hozzászólás</a>
                <?php        
                    endif;
                ?>
                <?php foreach($controller->getValue("comment_rows") as $row) {
                        echo '<div class="comment">';
                        echo '    <div class="comment-header">' . $row['user_name'] . ' ' . $row['create_date'] . '</div>';
                        echo '    <div class="comment-body">' . $row['content'] . '</div>';
                        echo '</div>';
                    }
                ?>
            </div>
        <div id="menu">
        	<ul>
                <?php 
                    if(!isset($_SESSION['user_data'])) :
                ?>
                    <li><a href="forum.php?page=login">Bejelentkezés</a></li>
                    <li><a href="#">Regisztráció</a></li>
                <?php        
                    endif;
                ?>
                <li>Fórum</li>               
                <?php 
                    if(isset($_SESSION['user_data'])) :
                ?>
                    <li><a href="#">Kijelentkezés</a></li>
                <?php        
                    endif;
                ?>
            </ul>
        </div>
        </div>             
