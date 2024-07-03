<?php
include 'database.php'; // Include the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analyzed Comments</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Analyzed Comments</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Review ID</th>
                    <th>Label</th>
                    <th>Created On</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Ensure $dbconn is defined from database.php
                if ($dbconn) {
                    $query = "SELECT * FROM public.analyzed_comments ORDER BY created_on DESC";
                    $comments_result = pg_query($dbconn, $query);

                    if ($comments_result) {
                        while ($row = pg_fetch_assoc($comments_result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['review_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['label']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['created_on']) . "</td>";
                            echo "</tr>";
                        }
                        pg_free_result($comments_result);
                    } else {
                        echo "Query failed: " . pg_last_error($dbconn);
                    }
                } else {
                    echo "Database connection failed.";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
