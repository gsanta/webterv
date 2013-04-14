<!-- <div id="ie6pagewrap"> -->
        <div id="container">
            <div id="content">
                <form id="login-form" action="forum.php?page=login&action=login" method="post">
                    <?php echo $controller->getValue("login_message"); ?>
                    <?php 
                        foreach ($controller->getValue("error_message") as $value) {
                            echo $value . "<br>";        
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
                <li><a href="forum.php?page=login">Bejelentkezés</a></li>
                <li><a href="#">Regisztráció</a></li>
                <li><a href="#">Fórum</a></li>
                <li><a href="#">Kijelentkezés</a></li>
            </ul>
        </div>
        </div><!--END CONTAINER-->                
