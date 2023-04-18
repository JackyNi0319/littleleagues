<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Little Leagues</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
  </head>
  <body>
    <header class="home_header">
      <h1><a href=""><img class="mascot" src="images/mascot.jpg">Little Leagues</a></h1>
    </header>
    <div class="bg-img-wrap home-bg">
      <main>
        <?php include "db_connect.php"?>
        <section>
          <h2>About Us</h2>
          <article class="left-align">
            <p>Welcome to the Little Leagues site, where the excitement of the game is always in full swing! Our league is dedicated to providing a fun and competitive basketball experience for players of all ages and skill levels. </p>
            <p>With a wide range of divisions and teams, there's always a challenge waiting on the court. Our league is designed to offer a safe and inclusive environment where players can improve their skills, make new friends, and have fun.We take pride in our commitment to fair play and sportsmanship. Our league officials work hard to ensure that games are well-organized, well-officiated, and played in a spirit of friendly competition.</p>
            <p>Whether you're a seasoned pro or just starting out, our basketball league has something for you. So come join us on the court and experience the thrill of the game for yourself. We look forward to seeing you there!</p>
          </article>
        </section>
        <section>
          <h2>Search for a Team:</h2>
          <form class="home-search" action="team.php">
            <label for="search_t"></label><br>
            <input type="text" id="search_t" name="team"><br>
            <button type="submit" value="Submit">Search</button>
          </form>
        </section>
        <section>
          <h2>Search for a Player:</h2>
          <form class="home-search" action="player.php">
            <label for="search_p"></label><br>
            <input type="text" id="search_p" name="player"><br>
            <button type="submit" value="Submit">Search</button>
          </form>
        </section>
        <section>
              <table>
                  <thead>
                      <tr>
                      <th>Our Teams</th>
                      </tr>
                  </thead>
                  <tbody>
          <?php
          $sql = "SELECT Team_name FROM TEAM";
      
          $results = $conn->query($sql);
      
          if(mysqli_num_rows($results) > 0){ // if one or more rows are returned do following
      
            while($row = $results->fetch_assoc()){
            // $results = mysql_fetch_array($raw_results) puts data from database into array, while it's valid it does the loop
            // output data of each row
              echo "<tr>
                      <td>" . $row["Team_name"] . "</td>
                  </tr>";
            }
          }
        ?>
        </tbody>
        </table>
        </section>
      </main>
    </div>
    <?php $conn->close();?>

    <footer>
      <p>&copy; 2023 Little Leagues</p>
    </footer>
    
    <script src="script."></script>
  </body>
</html>