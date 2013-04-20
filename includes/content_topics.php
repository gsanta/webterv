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
                            if(!isset($_SESSION['user_data']) || $row["last_read_date"] >= $row["last_comment_date"]) {
                                echo '<td><a href="forum.php?page=topic&topic_id=' . $row["id"] . '">' . $row["title"] . '</a></td>';
                            } else {
                                echo '<td><a href="forum.php?page=topic&topic_id=' . $row["id"] . '" class="unread">' . $row["title"] . '</a></td>';
                            }
                            echo '<td>' . $row["comments"] . '</td>';
                            echo '<td>' . $row["last_comment_by"] . ' - ' . $row["last_comment_date"] . '</td>';
                            echo '</tr>';
                        }
                    ?>
                </table>
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
                <li class="act-link">Fórum</li>               
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
