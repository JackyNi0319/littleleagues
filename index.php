<!DOCTYPE html>
<html lang="EN">
  <head>
    <title>Little Leagues Basketball</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <header class="home_header">
      <h1><a href=""><img class="mascot" src="images/mascot.jpg">Little Leagues Basketball</a></h1>
    </header>
    <main>
      <?php include "db_connect.php"?>

      <section>
        <h2>Search for a Team:</h2>
        <form class="home-search" action="team.php">
          <label for="search"></label><br>
          <input type="text" id="search" name="team"><br>
          <button type="submit" value="Submit">Search</button>
        </form>
      </section>

      <section>
      <h2>Our Teams</h2>
            <table>
                <thead>
                    <tr>
                    <th>Team</th>
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
    <?php $conn->close();?>

    <footer>
      <p>&copy; 2023 Basketball Team Management</p>
    </footer>
  </body>
</html>