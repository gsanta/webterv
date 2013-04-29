        <div id="container">
            <div id="content">
                <div id="topic-new-form" class="form-container">  
                    <form action="forum.php?page=new_topic" method="post">

                        <fieldset>
                        <legend>Új topik</legend>

                            <input type="hidden" name="action" value="add_topic"/>
                            <?php 
                                if($controller->getValue("error_message") != "") {
                                    echo '<span class="error-message">' . $controller->getValue("error_message") . '</a>';
                                }
                            ?>
                            <table>  
                                <tr>
                                    <td><label for="title">Cím:</label></td>
                                    <td><input type="text" name="title" id="title" value=""/></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <textarea name="comment"></textarea>
                                    </td>
                                <tr>
                                <tr>
                                    <td colspan="2" class="form-center"><input type="submit" name="new_topic" value="Elküld"></td>
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
