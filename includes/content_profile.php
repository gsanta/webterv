        <div id="container">
            <div id="content">
                <div id="profile-form" class="form-container">  
                    <form action="forum.php?page=profile" method="post" enctype="multipart/form-data">

                        <fieldset>
                        <legend>Profilkép</legend>
                            <input type="hidden" name="action" value="upload"/>
                            <?php 
                                if($controller->getValue("error_message") != "") {
                                    echo '<span class="error-message">' . $controller->getValue("error_message") . '</a>';
                                }
                            ?>
                            <table>
                                <tr>
                                    <td><label for="file">Fájl név:</label></td>
                                    <td><input type="file" name="file"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="form-center"><input type="submit" name="upload" value="Feltölt"></td>
                                </tr>          
                            </table>
                        </legend>
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
                        <li><a href="forum.php?page=registration">Regisztráció</a></li>
                    <?php        
                        endif;
                    ?>
                    <li><a href="forum.php?page=topics">Fórum</a></li>               
                    <?php 
                        if(isset($_SESSION['user_data'])) :
                    ?>
                        <li class="act-link">Profilkép</li>
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
        </div>             
