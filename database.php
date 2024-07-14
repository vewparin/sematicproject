<?php
  $dbconn = pg_connect("host=localhost port=5432 dbname=sematicadmin user=postgres password=rootpostgres") or die('Could not connect: ' . pg_last_error());
                            if (!$dbconn)
                            {
                                die('Error: Could not connect: ' . pg_last_error());
                            }
?>