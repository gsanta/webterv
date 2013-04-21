        <div id="container">
            <div id="content">
                <div id="profile-form">  
                    <form action="forum.php?page=profile" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="upload"/>
                        <?php 
                            if($controller->getValue("error_message") != "") {
                                echo '<span class="error-message">' . $controller->getValue("error_message") . '</a>';
                            }
                        ?>
                        <table>
                            <tr>
                                <th colspan="2">Profilkép feltöltése</th>
                            </tr>
                            <tr>
                                <td><label for="file">Fájl név:</label></td>
                                <td><input type="file" name="file"></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="form-center"><input type="submit" name="upload" value="Feltölt"></td>
                            </tr>          
                        </table>
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
                        <li class="act-link">Profilkép</li>
                    <?php        
                        endif;
                    ?>
                </ul>
            </div>
        </div>             
