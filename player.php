<!DOCTYPE html>
<html lang="en">
<head>
    <title>Little Leagues - Player</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/noresults.css">
</head>
<body>
    <?php 
      include_once "db_connect.php";
      //PERSON(Ssn, Nm, Dob, Address, Phone_no)
      // PERSONALSTATS(Ssn, Assists, Rebounds, Games_played, Steals, Shoot_percent, Free_throw_percent)
      // Player(Ssn, Playerid, Height, Weight, Pos, Jersey_no, Salary, Team_id, Agentssn)
      $formkeyword = $mysqli->real_escape_string($_GET["player"]);
      $playerName = "";
      $teamName = "";

      // if string, chars > 2; if number, num len > 0
      if (!empty($formkeyword) && is_string($formkeyword) && strlen($formkeyword) > 1 || !empty($formkeyword) && is_numeric($formkeyword) && strlen($formkeyword) > 2) {

        $sql = "SELECT Nm, Address, Pos, Height, Weight, Assists, Rebounds, Games_played, Steals, Shoot_percent, Free_throw_percent, Team_name
        FROM ((PERSONAL_STATS JOIN PLAYER ON PERSONAL_STATS.Ssn=PLAYER.Ssn) JOIN PERSON ON PLAYER.Ssn=PERSON.Ssn) JOIN TEAM ON PLAYER.TEAM_id=TEAM.TEAM_id 
        WHERE PLAYER.Playerid='%" . $formkeyword . "%' OR PERSON.Nm LIKE '%" . $formkeyword . "%'";

        $result = $conn->query($sql);
        if ($result !== false && $result->num_rows > 0) {    
          // output data of each row
          while($row = $result->fetch_assoc()) {
          $playerName = $row["Nm"];
          $teamName = $row["Team_name"];
    ?>
    <header>
      <h1><a href="./"><img class="mascot" src="images/mascot.jpg">Little Leagues</a></h1>
      <nav>
        <ul>
          <li><a href="./">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#stats">Stats</a></li>
        </ul>
      </nav>
    </header>
    <div class="bg-img-wrap player-bg">
        <main>
            <section id="about" style="margin-bottom:0;">
                <figure class="portrait">
                    <figcaption>
                    <h2><?php echo $playerName; ?></h2>
                    </figcaption>
                    <img src="https://api.dicebear.com/6.x/personas/svg?seed=<?php echo $playerName?>&backgroundType=solid&facialHairProbability=50&hair=bald,balding,bobBangs,bobCut,buzzcut,curly,curlyBun,curlyHighTop,fade,mohawk,pigtails,shortCombover,shortComboverChops,straightBun&hairColor=362c47,6c4545,e15c66,e16381,f27d65,f29c65&mouth=bigSmile,pacifier,smile,smirk,surprise&nose=mediumRound,smallRound&backgroundColor=b6e3f4,c0aede,d1d4f9,ffd5dc,ffdfbf" alt="<?php echo $playerName; ?>'s portrait"/></figure>
                <hr>
                <article class="left-align">
                <p>Meet <?php echo $playerName; ?>, a basketball player whose skill, talent, and dedication have made them a true force to be reckoned with on the court. <?php echo explode(" ", $playerName)[1]; ?> has a passion for the game that has driven them to become one of the best players in the league.</p>
        
                <p>Born and raised in <strong><?php echo ucfirst($row["Address"]); ?></strong>, <?php echo explode(" ", $playerName)[1]; ?> grew up playing basketball and quickly developed a love for the sport. As a child, <?php echo explode(" ", $playerName)[1]; ?> spent countless hours practicing their dribbling, shooting, and passing skills, always striving to improve. <?php echo explode(" ", $playerName)[1]; ?>'s' hard work paid off and soon began to stand out as a standout player in their local league. <?php echo explode(" ", $playerName)[1]; ?> quickly gained a reputation for their impressive speed, agility, and accuracy on the court.</p>
                <p>After graduating from high school, <?php echo explode(" ", $playerName)[1]; ?> was recruited by <strong><?php echo explode(" ", $playerName)[1]; ?> University</strong>, where they continued to hone their skills and develop their game. During their time at <strong><?php echo explode(" ", $playerName)[1]; ?> University</strong>, they made a name for themselves as one of the most talented players in the league.</p>
                <p>Since then, <?php echo explode(" ", $playerName)[1]; ?> has gone on to achieve even greater success, playing professionally for the <strong><?php echo $teamName; ?></strong>. Their talent and dedication have earned them numerous awards and accolades, as well as the respect and admiration of their peers and fans.</p>
                </article>
                <hr>
            </section>
            <section id="stats">
            <h2><?php echo $playerName ?>'s Stats</h2>
            <table>
                <thead>
                    <tr>
                    <th>Position</th>
                    <th>Height</th>
                    <th>Weight</th>
                    <th>Assists</th>
                    <th>Rebounds</th>
                    <th>Games Played</th>
                    <th>Steals</th>
                    <th>Shoot%</th>
                    <th>Freethrow%</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $heightImperial =  floor((($row["Height"] * 100) / 2.54) / 12) . "'" . (ceil(($row["Height"] * 100) / 2.54) % 12) . '"';
                        $weightImperial = ceil($row["Weight"] * 2.205) . "lb";
                        // output data of each row
                        echo "<tr>
                        <td>" . $row["Pos"] . "</td>
                        <td>" . $heightImperial . " (" . $row["Height"] . "m)" . "</td>
                        <td>" . $weightImperial . " (" . $row["Weight"] . "kg)" . "</td>
                        <td>" . $row["Assists"] . "</td>
                        <td>" . $row["Rebounds"] . "</td>
                        <td>" . $row["Games_played"] . "</td>
                        <td>" . $row["Steals"] . "</td>
                        <td>" . $row["Shoot_percent"] . "</td>
                        <td>" . $row["Free_throw_percent"] . "</td>
                        </tr>";
                        }
                    ?>
                </tbody>
            </table>
          </section>
        </main>
    </div>
    <footer>
      <p>&copy; <?php echo date("Y"); ?> Little Leagues</p>
    </footer>
    <?php
        } else {
    ?>
  <main class="no-results" style="background-color:white">
      <section>
        <img src="images/basketball_search.jpg" alt="basketball mascot">
        <h1>Sorry, no results found.</h1>
        <p>We could not find any results for the player you're looking for. Please try searching for another player at the</br><a href="./">homepage</a>.</p>
      </section>
    </main>
    <?php
          }
        } else {
    ?>
      <main class="no-results" style="background-color:white">
      <section>
        <img src="images/basketball_search.jpg" alt="basketball mascot">
        <h1>Sorry, no results found.</h1>
        <p>We could not find any results for the player you're looking for. Please try searching for another player at the</br><a href="./">homepage</a>.</p>
      </section>
    </main>
    <?php
        }
    ?>
    <?php $conn->close();?>

    <script src="script."></script>
</body>
</html>