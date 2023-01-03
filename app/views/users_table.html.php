<div>
	<table>
        <?php
        foreach($users as $user){
        echo "<tr><td> Weekday the ".$user['day']." of ".$user['monthname'].": <span style='color:green;'>".$user['weekday']."</span></td><td>".$user['name']."</td></tr>";
        }
        ?>
	</table>

</div>