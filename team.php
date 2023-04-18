<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Little Leagues - Team</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/noresults.css">
  </head>
  <body>
  <?php 
      include_once "db_connect.php";
      //PERSON(Ssn, Nm, Dob, Address, Phone_no)
      // PERSONALSTATS(Ssn, Championships, Assists, Rebounds, Games_played, Steals, Shoot_percent, Free_throw_percent)
      $formkeyword = $_GET["team"];
      $teamName = "";

      // if string, chars > 2; if number, num len > 0
      if (!empty($formkeyword) && is_string($formkeyword) && strlen($formkeyword) > 2 || !empty($formkeyword) && is_numeric($formkeyword) && strlen($formkeyword) > 0) {

      $sql = "SELECT Team_name, Championships, Wins, Losses FROM TEAM WHERE Team_id LIKE '%" . $formkeyword . "%'" . " OR Team_name LIKE '%" . $formkeyword . "%'";

      $result = $conn->query($sql);
      if ($result !== false && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $teamName = $row["Team_name"];
      ?>
    <header>
      <h1><a href="./"><img class="mascot" src="images/mascot.jpg">Little Leagues</a></h1>
      <nav>
        <ul>
          <li><a href="./">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#player">Players</a></li>
          <li><a href="#schedule">Schedule</a></li>
        </ul>
      </nav>
    </header>
    <main>
      <section id="about">
        <figure class="team-logo">
          <img src="https://api.dicebear.com/6.x/identicon/svg?seed=<?php echo $teamName; ?>&backgroundType=gradientLinear&backgroundColor[]" alt="avatar" />
          <figcaption>
            <h2><?php echo $teamName; ?></h2>
          </figcaption>
        </figure>
        <article class="left-align">
          <p>Welcome to the <?php echo $teamName; ?>'s page! We are a group of dedicated players who are passionate about the game and committed to achieving success on the court. As a team, we pride ourselves on hard work, determination, and a never-give-up attitude. We believe that every player has something unique to contribute and that by working together, we can achieve our goals and reach new heights. </p>
          <p> Our team is more than just a group of players. We are a tight-knit community that supports and encourages one another both on and off the court. We believe in sportsmanship, fair play, and respect for our opponents, coaches, and fans. We are constantly striving to improve our skills and tactics, always looking for new ways to outsmart and outplay our opponents. We know that success doesn't come easy, but we're willing to put in the hard work and dedication it takes to achieve it.</p>
        </article>
      </section>
      <section>
        <h2>Team Stats</h2>
        <table>
            <thead>
                <tr>
                <th>Team</th>
                <th>Chamionships</th>
                <th>Wins</th>
                <th>Losses</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // output data of each row
                      echo "<tr> 
                              <td>" . $row["Team_name"] . "</td>
                              <td>" . $row["Championships"] . "</td>
                              <td>" . $row["Wins"] . "</td>
                              <td>" . $row["Losses"] . "</td>
                          </tr>";
                    }
                ?>
            </tbody>
        </table>
      </section>

      <section id="player">
        <h2>Our Roster Stats</h2>
        <table>
          <thead>
              <tr>
              <th>Name</th>
              <th>Position</th>
              <th>Chamionships</th>
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
              $sql = "SELECT Nm, Pos, PERSONAL_STATS.Championships, Assists, Rebounds, Games_played, Steals, Shoot_percent, Free_throw_percent 
              FROM ((PERSONAL_STATS JOIN PLAYER ON PERSONAL_STATS.Ssn=PLAYER.Ssn) JOIN PERSON ON PLAYER.Ssn=PERSON.Ssn) JOIN TEAM ON PLAYER.TEAM_id=TEAM.TEAM_id 
              WHERE TEAM.Team_id='%" . $formkeyword . "%' OR TEAM.Team_name LIKE '%" . $formkeyword . "%'";

              $result = $conn->query($sql);
              if ($result !== false && $result->num_rows > 0) {    
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr> 
                            <td>" . $row["Nm"] . "</td>
                            <td>" . $row["Pos"] . "</td>
                            <td>" . $row["Championships"] . "</td>
                            <td>" . $row["Assists"] . "</td>
                            <td>" . $row["Rebounds"] . "</td>
                            <td>" . $row["Games_played"] . "</td>
                            <td>" . $row["Steals"] . "</td>
                            <td>" . $row["Shoot_percent"] . "</td>
                            <td>" . $row["Free_throw_percent"] . "</td>
                        </tr>";
                }
              } else {
                echo "0 results";
                }
            ?>
          </tbody>
        </table>
      </section>

      <section id="schedule">
        <h2>Recent Games</h2>
        <table>
          <thead>
            <tr>
              <th>Stadium</th>
              <th>Date</th>
              <th>Opponent</th>
              <th>Location</th>
              <th>Score(H-A)</th>
            </tr>
          </thead>
          <tbody>
            <?php
              // GAME (Stadium, Dt, Home_team, Away_team, Score) 
              // COMPETE (Stadium, Dt, Home_team_id, Away_team_id)

              $sql = "SELECT DISTINCT GAME.Stadium, GAME.Dt, Away_team, Home_team, Score
              FROM COMPETE JOIN GAME ON COMPETE.Stadium=GAME.Stadium AND GAME.Dt=COMPETE.Dt
              WHERE Home_team_id='%" . $formkeyword . "%' OR Away_team_id='%" . $formkeyword . "%' OR Home_team LIKE '%" . $formkeyword . "%' OR Away_team LIKE '%" . $formkeyword . "%'
              ORDER BY GAME.Dt";

              $result = $conn->query($sql);
              if ($result !== false && $result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr> 
                            <td>" . $row["Stadium"] . "</td>
                            <td>" . $row["Dt"] . "</td>";
                    if ($row["Home_team"] == $teamName) {
                        echo '<td class="team-logo-score"> <img src="https://api.dicebear.com/6.x/identicon/svg?seed=' . $row["Away_team"] . '&backgroundType=gradientLinear&backgroundColor[]" alt="avatar" />' . $row["Away_team"] . "</td>
                              <td> Home </td>";
                    } else {
                      echo '<td class="team-logo-score"> <img src="https://api.dicebear.com/6.x/identicon/svg?seed=' . $row["Home_team"] . '&backgroundType=gradientLinear&backgroundColor[]" alt="avatar" />' . $row["Home_team"] . "</td>
                            <td> Away </td>";
                    }
                    echo "  <td>" . $row["Score"] . "</td>
                        </tr>";
                }
              } else {
                echo "zero Results";
              }
            ?>
          </tbody>
        </table>
      </section>
    </main>
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
        <p>We could not find any results for the team you're looking for. Please try searching for another team at the</br><a href="./">homepage</a>.</p>
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
        <p>We could not find any results for the team you're looking for. Please try searching for another team at the</br><a href="./">homepage</a>.</p>
      </section>
    </main>
    <?php
        }
    ?>
    <?php $conn->close();?>

    <script src="script."></script>
  </body>
</html>