<?php
class CrudOperations
{
    private $conn;

    public function __construct($servername, $username, $password, $dbname)
    {
        $this->conn = new mysqli($servername, $username, $password, $dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function createRecord($table, $data, $uniqueColumns)
    {
        // Check if a record with the same values in uniqueColumns already exists
        $sqlCheckExistence = "SELECT COUNT(*) as count FROM $table WHERE ";
        $conditions = array();
        $values = array();

        foreach ($uniqueColumns as $column) {
            $conditions[] = "$column = ?";
            $values[] = $data[$column];
        }

        $sqlCheckExistence .= implode(" AND ", $conditions);

        // Use prepared statement to avoid SQL injection
        $stmtCheckExistence = $this->conn->prepare($sqlCheckExistence);
        $stmtCheckExistence->bind_param(str_repeat('s', count($values)), ...$values);

        $stmtCheckExistence->execute();
        $result = $stmtCheckExistence->get_result();

        if ($result) {
            $row = $result->fetch_assoc();
            $count = $row['count'];

            if ($count > 0) {
                // Display JavaScript popup for record existence
                echo "<script>
                alert('Record already exists');
                window.location.href = '" . $_SERVER['PHP_SELF'] . "';
                </script>";
                unset($_POST);
                exit;
            } else {
                // Record does not exist, proceed with insertion
                $fields = implode(", ", array_keys($data));
                $placeholders = implode(", ", array_fill(0, count($data), '?'));

                $sqlInsert = "INSERT INTO $table ($fields) VALUES ($placeholders)";

                // Use prepared statement for insertion
                $stmtInsert = $this->conn->prepare($sqlInsert);
                $stmtInsert->bind_param(str_repeat('s', count($data)), ...array_values($data));

                if ($stmtInsert->execute()) {
                    // Display JavaScript popup for successful insertion
                    echo "<script>
                    alert('Record inserted successfully');
                    window.location.href = '" . $_SERVER['PHP_SELF'] . "';
                    </script>";
                    unset($_POST);
                    exit;
                } else {
                    // Display JavaScript popup with insertion error message
                    echo "<script>
                    alert('Insertion Error: " . $stmtInsert->error . "');
                    window.location.href = '" . $_SERVER['PHP_SELF'] . "';
                    </script>";
                    unset($_POST);
                    exit;
                }

                $stmtInsert->close();
            }
            $stmtCheckExistence->close();
        } else {
            // Handle error in checking existence
            echo "<script>
            alert('Error checking existence: " . $this->conn->error . "');
            window.location.href = '" . $_SERVER['PHP_SELF'] . "';
            </script>";
            unset($_POST);
            exit;
        }
    }



    public function readRecords($table)
    {
        $sql = "SELECT * FROM $table";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $records = array();
            while ($row = $result->fetch_assoc()) {
                $records[] = $row;
            }
            return $records;
        } else {
            return "No records found";
        }
    }
    public function readRecordsWithConditions($table, $conditions)
    {
        $whereClause = $this->buildWhereClause($conditions);
        $sql = "SELECT * FROM $table WHERE $whereClause";

        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $records = array();
            while ($row = $result->fetch_assoc()) {
                $records[] = $row;
            }
            return $records;
        } else {
            return "No records found";
        }
    }

    // public function updateRecord($table, $conditions, $data)
    // {
    //     $updates = "";
    //     foreach ($data as $key => $value) {
    //         $updates .= "$key='$value', ";
    //     }
    //     $updates = rtrim($updates, ", ");

    //     $whereClause = $this->buildWhereClause($conditions);

    //     $sql = "UPDATE $table SET $updates WHERE $whereClause";

    //     if ($this->conn->query($sql) === TRUE) {
    //         // Display JavaScript popup and redirect
    //         echo "<script>
    //                 alert('Record updated successfully');
    //                 window.location.href = '" . $_SERVER['PHP_SELF'] . "';    
    //               </script>";
    //     } else {
    //         // Display JavaScript popup with error message
    //         echo "<script>
    //                 alert('Error updating record: " . $this->conn->error . "');
    //               </script>";
    //     }
    // }
    public function updateRecords($table, $conditions, $data)
    {
        $updates = "";
        foreach ($data as $key => $value) {
            $updates .= "$key='$value', ";
        }
        $updates = rtrim($updates, ", ");

        $whereClause = $this->buildWhereClause($conditions);

        $sql = "UPDATE $table SET $updates WHERE $whereClause";

        if ($this->conn->query($sql) === TRUE) {
            $status_updation = 1;
        } else {
            $status_updation = 0;
        }
    }

    private function buildWhereClause($conditions)
    {
        $where = "";
        foreach ($conditions as $field => $value) {
            $where .= "$field = '$value' AND ";
        }
        $where = rtrim($where, " AND ");
        return $where;
    }


    public function deleteRecord($table, $id)
    {
        $sql = "DELETE FROM $table WHERE id=$id";

        if ($this->conn->query($sql) === TRUE) {
            return "Record deleted successfully";
        } else {
            return "Error deleting record: " . $this->conn->error;
        }
    }



    public function closeConnection()
    {
        $this->conn->close();
    }

    public function readSingleRecordColumn($table, $column, $conditions, &$outputVariable)
    {
        $whereClause = $this->buildWhereClause($conditions);
        $sql = "SELECT $column FROM $table WHERE $whereClause";

        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $outputVariable = $row[$column];
        } else {
            $outputVariable = null; // or whatever default value you want to assign
        }
    }
    // left join read 
    public function readRecordsWithConditionsAndLeftJoins($table, $conditions, $joins)
    {
        $whereClause = $this->buildWhereClause($conditions);

        // Build left join clauses
        $joinClauses = "";
        foreach ($joins as $join) {
            $joinClauses .= " LEFT JOIN {$join['table']} ON {$join['condition']}";
        }

        // Modify the SQL query to include left join clauses
        $sql = "SELECT * FROM $table $joinClauses WHERE $whereClause";

        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $records = array();
            while ($row = $result->fetch_assoc()) {
                $records[] = $row;
            }
            return $records;
        } else {
            return "No records found";
        }
    }
}

$crud = new CrudOperations("localhost", "u977112581_gmiutest", "Test@123?", "u977112581_gmiutest");
