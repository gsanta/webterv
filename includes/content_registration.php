<!-- <div id="ie6pagewrap"> -->
        <div id="container">
            <div id="content">
                <div id="registration-form" class="form-container">
                <form  action="forum.php?page=registration&action=registrate" method="post">
                    <fieldset>
                        <legend>Regisztráció</legend>
                        <?php
                            $error_message = $controller->getValue("error_message");
                            foreach ($controller->getValue("message") as $value) {
                                echo '<span class="message">' . $value . "</span><br>";
                            } 
                        ?>
                        <table>
                            <tr>
                                <td><label for="user-name"><?php echo $controller->getValue("user_name_label"); ?></label></td>
                                <td>
                                    <input type="text" name="user_name" id="user-name" value="<?php echo $controller->getValue("user_name"); ?>"/>
                                    <?php 
                                        if($error_message["user_name"] != "") {
                                            echo '<br><span class="error-message">' . $error_message["user_name"] . '</span>'; 
                                        }

                                        if($error_message["user_name_not_unique"] != "") {
                                            echo '<br><span class="error-message">' . $error_message["user_name_not_unique"] . '</span>';
                                        }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="password"><?php echo $controller->getValue("password_label"); ?></label></td>
                                <td>
                                    <input type="password" id="password" name="password"/ value="<?php echo $controller->getValue("password"); ?>">
                                    <?php 
                                        if($error_message["password"] != "") {
                                            echo '<br><span class="error-message">' . $error_message["password"] . '</span>';
                                        }

                                        if($error_message["password_not_match"] != "") {
                                            echo '<br><span class="error-message">' . $error_message["password_not_match"] . '</span>';
                                        }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="password-repeat"><?php echo $controller->getValue("password_repeat_label"); ?></label></td>
                                <td>
                                    <input type="password" name="password_repeat" id="password-repeat" value="<?php echo $controller->getValue("password_repeat"); ?>"/>

                                    <?php 
                                        if($error_message["password_repeat"] != "") {
                                            echo '<br><span class="error-message">' . $error_message["password_repeat"] . '</span>'; 
                                        }

                                        if($error_message["password_not_match"] != "") {
                                            echo '<br><span class="error-message">' . $error_message["password_not_match"] . '</span>';
                                        }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="email"><?php echo $controller->getValue("email_label"); ?></label></td>
                                <td>
                                    <input type="text" name="email" id="email" value="<?php echo $controller->getValue("email"); ?>"/>
                                    <?php 
                                        if($error_message["email"] != "") {
                                            echo '<br><span class="error-message">' . $error_message["email"] . '</span>';
                                        }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"><input type="submit" value="<?php echo $controller->getValue("registration_label"); ?>"/></td>
                            </tr>
                        </table>
                     </fieldset>   
                </form>
                </div>
            </div>
        <div id="menu">
            <?php 
                    if(isset($_SESSION['user_data'])) {
                        echo 'Üdv, ' . $_SESSION['user_data']['name'] . '!';
                    }
            ?>
        	<ul id="menu-list">
                <?php 
                    if(!isset($_SESSION['user_data'])) :
                ?>
                    <li><a href="forum.php?page=login">Bejelentkezés</a></li>
                    <li class="act-link">Regisztráció</li>
                <?php        
                    endif;
                ?>
                <li><a href="forum.php?page=topics">Fórum</a></li>               
                <?php 
                    if(isset($_SESSION['user_data'])) :
                ?>  
                    <li><a href="forum.php?page=profile">Profilkép</a></li>
                    <li><a href="forum.php?page=logout">Kijelentkezés</a></li>
                <?php        
                    endif;
                ?>          
            </ul>

            <?php 
                    if(isset($_SESSION['user_data'])) {
                        echo '<img id="profile" src="upload/' . $_SESSION['user_data']['image_name'] . '" width="100" alt="profil kép"/>';
                    }
                ?>

                <?php 
                    if(isset($_SESSION['user_data'])) :
                ?>
                    <div id="active-users">
                            Aktív felhasználók:

                            <ul>
                            <?php
                                foreach ($controller->getValue("active_users") as $row) {
                                    echo '<li>' . $row['name'] . '</li>';
                                }
                            ?>
                            </ul>
                    </div>
                <?php
                     endif;
                ?>
        </div>
        </div><!--END CONTAINER-->                
