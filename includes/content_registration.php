<!-- <div id="ie6pagewrap"> -->
        <div id="container">
            <div id="content">
                <form id="registration-form" action="forum.php?page=registration&action=registrate" method="post">
                    <?php
                        $error_message = $controller->getValue("error_message");
                    ?>
                    <table>
                        <tr>
                            <td><?php echo $controller->getValue("user_name_label"); ?></td>
                            <td><input type="text" name="user_name" value="<?php echo $controller->getValue("user_name"); ?>"/></td>
                            <td><?php 
                                    echo $error_message["user_name"]; 
                                    echo $error_message["user_name_not_unique"];
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $controller->getValue("password_label"); ?></td>
                            <td><input type="password" name="password"/ value="<?php echo $controller->getValue("password"); ?>"></td>
                            <td>
                                <?php 
                                    echo $error_message["password"]; 
                                    echo $error_message["password_not_match"];
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $controller->getValue("password_repeat_label"); ?></td>
                            <td><input type="password" name="password_repeat" value="<?php echo $controller->getValue("password_repeat"); ?>"/></td>
                            <td><?php echo $error_message["password_repeat"]; ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $controller->getValue("email_label"); ?></td>
                            <td><input type="text" name="email" value="<?php echo $controller->getValue("email"); ?>"/></td>
                            <td><?php echo $error_message["email"]; ?></td>
                        </tr>
                        <tr>
                            <td colspan="3"><input type="submit" value="<?php echo $controller->getValue("registration_label"); ?>"/></td>
                        </tr>
                    </table>
                </form>
                <?php 
                    foreach ($controller->getValue("message") as $value) {
                        echo $value . "<br>";
                    } 
                ?>
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
