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
                            <td>
                                <input type="text" name="user_name" value="<?php echo $controller->getValue("user_name"); ?>"/>
                                <?php 
                                    echo '<br><span class="error-message">' . $error_message["user_name"] . '</span>'; 
                                    echo '<br><span class="error-message">' . $error_message["user_name_not_unique"] . '</span>';
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $controller->getValue("password_label"); ?></td>
                            <td>
                                <input type="password" name="password"/ value="<?php echo $controller->getValue("password"); ?>">
                                <?php 
                                    echo '<br><span class="error-message">' . $error_message["password"] . '</span>';
                                    echo '<br><span class="error-message">' . $error_message["password_not_match"] . '</span>';
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $controller->getValue("password_repeat_label"); ?></td>
                            <td>
                                <input type="password" name="password_repeat" value="<?php echo $controller->getValue("password_repeat"); ?>"/>
                                <?php echo '<br><span class="error-message">' . $error_message["password_repeat"] . '</span>'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $controller->getValue("email_label"); ?></td>
                            <td>
                                <input type="text" name="email" value="<?php echo $controller->getValue("email"); ?>"/>
                                <?php echo '<br><span class="error-message">' . $error_message["email"] . '</span>'; ?>
                            </td>
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
                <?php 
                    if(!isset($_SESSION['user_data'])) :
                ?>
                    <li><a href="forum.php?page=login">Bejelentkezés</a></li>
                    <li class="act-link"><a href="forum.php?page=registration">Regisztráció</a></li>
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
