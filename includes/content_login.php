<!-- <div id="ie6pagewrap"> -->
        <div id="container">
            <div id="content">
                <div id="login-form" class="form-container">
                    <form action="forum.php?page=login&action=login" method="post">
                        <fieldset>
                            <legend>Bejelentkezés</legend>

                            <?php echo $controller->getValue("login_message"); ?>
                            <?php 
                                foreach ($controller->getValue("error_message") as $value) {
                                    echo '<span class="error-message">' . $value . "</span><br>";        
                                }
                            ?>
                            <table>
                                <tr>
                                    <!-- <td>Felh. azonosító:</td> -->
                                    <td><label for="user-name"><?php echo $controller->getValue("user_name_label"); ?></label></td>
                                    <td><input type="text" name="user_name" id="user-name" value="<?php echo $controller->getValue("user_name"); ?>"/></td>
                                </tr>
                                <tr>
                                    <td><label for="password"><?php echo $controller->getValue("password_label"); ?></label></td>
                                    <td><input type="password" id="password" name="password"/></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><input type="submit" value="Bejelentkezés"/></td>
                                </tr>
                            </table>
                        </fieldset>
                    </form>
                </div>
            </div>
        <div id="menu">
        	<ul id="menu-list">
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
