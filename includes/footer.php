    </article>
    <aside>
        <?php if($_SESSION['level'] == "admin"){?>
        	<nav id="archives">
                <ul>
                <li><a href='../index.php'>Home</a></li>
                <li><a href='../index.php?p=users'>Users</a></li>
                <li><a href='../index.php?p=candidates'>Candidates</a></li>
                <li><a href='../index.php?p=positions'>Positions</a></li>
                <li><a href='../index.php?p=results'>Vote Results</a></li>
                <?php if(!isset($_SESSION['st_user_id'])){;?>
                <li><a href='../index.php?p=login'>Login</a></li>
				<?php }?>
            </ul>
        </nav>
        <?php }?>
        <?php if($_SESSION['level'] != "admin"){?>
        	<nav id="archives">
                <ul>
                <li><a href='../index.php'>Home</a></li>
                <li><a href='../index.php?p=candidates'>Candidates</a></li>
                <li><a href='../index.php?p=positions'>Positions</a></li>
                <li><a href='../index.php?p=results'>Vote Results</a></li>
                <?php if(!isset($_SESSION['st_user_id'])){;?>
                <li><a href='../index.php?p=login'>Login</a></li>
				<?php }?>
            </ul>
        </nav>
        <?php }?>
        
       
    </aside>
    <footer id="footer">
        
    </footer>
</section>
</body>
</html>