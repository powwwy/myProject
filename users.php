<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Users</title>
   <link rel="stylesheet" href="user.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Registered Users</h1>
            <p class="subtitle">All users in the system, ordered alphabetically by name</p>
        </header>
        
        <?php
        include 'connect.php';
        $sql = "SELECT name, email FROM users ORDER BY name ASC";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            echo '<input type="text" class="search-box" placeholder="Search users..." id="searchInput">';
            echo '<table class="users-table">';
            echo '<thead><tr>';
            echo '<th>Number</th>';
            echo '<th>Name</th>';
            echo '<th>Email</th>';
            echo '</tr></thead>';
            echo '<tbody>';
            
            while($row = $result->fetch_assoc()) {
                $users = range(1, $result->num_rows);
                static $i = 0;
                echo '<tr>';
                echo '<td class="id-cell">' .htmlspecialchars($users[$i]). '</td>';
                echo '<td class="name-cell">' . htmlspecialchars($row["name"]) . '</td>';
                echo '<td class="email-cell">' . htmlspecialchars($row["email"]) . '</td>';
                echo '</tr>';
                $i++;
            }
            
            echo '</tbody>';
            echo '</table>';
            
            echo '<div class="table-footer">';
            echo '<div>';
            
            echo '</div>';
            echo '<div>Total users: ' . $result->num_rows . '</div>';
            echo '</div>';
        } else {
            echo '<div class="no-users">';
            echo '<h3>No users found</h3>';
            echo '<p>There are currently no registered users in the system.</p>';
            echo '</div>';
        }
        
        $conn->close();
        ?>
        
    </div>

    <script>
        // Simple search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const rows = document.querySelectorAll('.users-table tbody tr');
            
            rows.forEach(row => {
                const name = row.querySelector('.name-cell').textContent.toLowerCase();
                const email = row.querySelector('.email-cell').textContent.toLowerCase();
                const id = row.querySelector('.id-cell').textContent.toLowerCase();
                
                if (name.includes(searchText) || email.includes(searchText) || id.includes(searchText)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
