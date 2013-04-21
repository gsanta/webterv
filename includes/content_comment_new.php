        <div id="container">
            <div id="content">
                <div id="comment-new-form">
                    Új hozzászólás ide: <?php echo $controller->getValue("topic_title"); ?>
                    <form action="forum.php?page=new_comment" method="post">
                        <input type="hidden" name="topic_id" value="<?php echo $controller->getValue("topic_id"); ?>"/>
                        <input type="hidden" name="action" value="add_comment"/>
                        <textarea name="content"></textarea><br>    
                        <input type="submit" name="new_comment" value="Elküld">
                    </form>
                </div>
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
