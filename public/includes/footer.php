    </article>
    <aside>
        	<nav id="archives">
                <ul>
                <li><a href='index.php'>Home</a></li>
                <!--<li><a href='../index.php?p=departments'>Departments</a></li>-->
                <?php if(admin()){;?>
                <li><a href='index.php?p=departments'>Academic units</a></li>
                <li><a href='index.php?p=sub_departments'>Departments</a></li>
                <li><a href='index.php?p=courses'>Courses</a></li>
                <li><a href='index.php?p=course_units'>Course Units</a></li>
                <li><a href='index.php?p=questions'>Questions</a></li>
                <li><a href='index.php?p=program'>Programs</a></li>
                <li><a href='index.php?p=title'>Titles</a></li>
                <li><a href='index.php?p=position'>Positions</a></li>
                <li><a href='index.php?p=users'>Staff</a></li>
                <li><a href='index.php?p=students'>Students</a></li>
                <li><a href='index.php?p=students_completion_full'>Students status</a></li>
                <li><a href='index.php?p=students_partially_registered'>Help</a></li>
                <li><a href='index.php?p=question_category'>Question category</a></li>
                <li><a href='http://home.umu.ac.ug'>UMU Home</a></li>
                
				<?php ?>
                <?php }elseif(!$session->session_no){;?>
                <li><a href='index.php?p=login'>Login</a></li>
                <li><a href='index.php?p=students_partially_registered'>Help</a></li>
                
                <li><a href='http://home.umu.ac.ug'>UMU Home</a></li>
                <li><a href='http://catalogue.umu.ac.ug:85/'>Demo</a></li>
				<?php }else{?>	
                <?php 
				$student_course = return_student_course($session->user_id);
				if($student_course){?>
					<!--<li><a href='../index.php?c=course&p=course&course_id=<?php echo urlencode(base64_encode($student_course));?>'>Evaluate Course</a></li>-->
                    <li><a href='index.php?c=student&p=student&user_id=<?php echo urlencode(base64_encode($session->user_id));?>'>Evaluate Course</a></li>
				<?php } else{?>
                	<li><a href='index.php?c=student&p=student&user_id=<?php echo urlencode(base64_encode($session->user_id));?>'>Evaluate Course</a></li>
				<?php }?>
            <?php }?>
            </ul>
        </nav>
        
       
    </aside>
    <footer id="footer">
        
    </footer>
</section>
</body>
</html>