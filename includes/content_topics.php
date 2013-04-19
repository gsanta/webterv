        <div id="container">
            <div id="content">
                <table id="table-topics">
                    <tr>
                        <th rowspan="2" class="first-column">Téma címe</th>
                        <th colspan="2">Információk</th>
                    </tr>
                    <tr>
                        <th class="second-column">Hozzászólások száma</th>
                        <th class="third-column">Utolsó hozzászólás felhasználója és ideje</th>
                    </tr>

                    <?php
                        foreach ($controller->getValue("topic_rows") as $row) {
                            echo '<tr>';
                            echo '<td><a href="forum.php?page=topic&topic_id=' . $row["id"] . '">' . $row["title"] . '</a></td>';
                            echo '<td>' . $row["comments"] . '</td>';
                            echo '<td>' . $row["last_comment_by"] . $row["create_date"] . '</td>';
                            echo '</tr>';
                        }
                    ?>
                </table>
            </div>
        <div id="menu">
        	<ul>
                <?php 
                    if(!isset($_SESSION['user_data'])) :
                ?>
                    <li><a href="forum.php?page=login">Bejelentkezés</a></li>
                    <li><a href="forum.php?page=registration">Regisztráció</a></li>
                <?php        
                    endif;
                ?>
                <li class="act-link"><a href="forum.php?page=topics">Fórum</a></li>               
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
