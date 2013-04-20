<!-- <div id="ie6pagewrap"> -->
        <div id="container">
            <div id="content">
                <form id="login-form" action="forum.php?page=login&action=login" method="post">
                    <?php echo $controller->getValue("login_message"); ?>
                    <?php 
                        foreach ($controller->getValue("error_message") as $value) {
                            echo '<span class="error-message">' . $value . "</span><br>";        
                        }
                    ?>
                    <table>
                        <tr>
                            <!-- <td>Felh. azonosító:</td> -->
                            <td><?php echo $controller->getValue("user_name_label"); ?></td>
                            <td><input type="text" name="user_name" value="<?php echo $controller->getValue("user_name"); ?>"/></td>
                        </tr>
                        <tr>
                            <td><?php echo $controller->getValue("password_label"); ?></td>
                            <td><input type="password" name="password"/></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="submit" value="Bejelentkezés"/></td>
                        </tr>
                    </table>
                    
                </form>
            </div>
        <div id="menu">
        	<ul>
                <?php 
                    if(!isset($_SESSION['user_data'])) :
                ?>
                    <li class="act-link">Bejelentkezés</li>
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
        </div><!--END CONTAINER-->                
