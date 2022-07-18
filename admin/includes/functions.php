<?php

// This sanitizes the input of the
function sanitizeInputs($conn, $input)
{
    $input = trim($input);
    $input = mysqli_real_escape_string($conn, $input);
    return $input;
}

//login functions

/**
 * 
 * This function takes @param password to hash the password with SHA-512 algorithm
 * @return password (hashed password)
 */
function hashPassword($password)
{
    $SHA_512 = "$6$";
    $hashFormat = $SHA_512 . "rounds=5000";
    $salt = "sananamanpansininakonicrushuwu<3<3<3";
    $hash = $hashFormat . $salt;

    $password = crypt($password, $hash);

    return $password;
}

/**
 * 
 * This verifies the password and takes 2 params @param password and @param dbPassword
 * the password is the raw password taken from the login function and the dbPassword is the hashed password that is crypted
 * we will crypt the @param password and compare if both are equals to @param dbPassword.
 * if both are same we @return true else @return false
 */

function verifyPassword($password, $dbPassword)
{
    $SHA_512 = "$6$";
    $hashFormat = $SHA_512 . "rounds=5000";
    $salt = "sananamanpansininakonicrushuwu<3<3<3";
    $hash = $hashFormat . $salt;

    if (crypt($password, $hash) == $dbPassword) {
        return true;
    } else {
        return false;
    }
}

/**
 * 
 * This is the login function this only verifies if the selected password is selected
 * it takes 3 params @param conn (database connection), @param username, @param password
 * if the number of rows is greater than 1 @return true else @return false 
 */
function login($conn, $username, $password)
{
    $query = "SELECT username, password, role FROM application_portal_admin WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = mysqli_fetch_assoc($result);
    if (verifyPassword($password, $rows["password"])) {
        $numRow = mysqli_num_rows($result);
        if ($numRow > 0) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

/**
 * 
 * this function authorize the user it takes 4 params
 * @param conn
 * @param username
 * @param password
 * @param role
 * 
 * this authorize the user with their specific role and logs in the user
 * if the row that comes from the database is equals to the inputted row then @return true
 * else @return false
 */
function authorizeUser($conn, $username, $password, $role)
{
    $query = "SELECT role FROM application_portal_admin WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if ($row["role"] == $role) {
        login($conn, $username, $password);
        return true;
    } else {
        return false;
    }
}

// admin/moderator dashboard functions

/**
 * 
 * this fetches the applicant with their identified id
 * takes @param conn for database connection
 * @param id for the user id
 * 
 * @return row or the result of the user that comes from the database
 */
function getApplicantById($conn, $id)
{
    $query = "SELECT * FROM application_portal WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row;
}

/**
 * 
 * checks if the fields are empty 
 * if empty @return true
 * else @return false
 */
function isFieldsEmpty($name, $email, $contact_no, $school, $branch, $course, $skills, $fow, $resume)
{
    if (
        empty($name) ||
        empty($email) ||
        empty($contact_no) ||
        empty($school) ||
        empty($branch) ||
        empty($course) ||
        empty($skills) ||
        empty($fow) ||
        empty($resume)
    ) {
        return true;
    } else {
        return false;
    }
}

/**
 * 
 * this updates the details of the applicant
 * receives the params
 * 
 * @param conn - for database connection
 * @param name
 * @param status
 * @param email
 * @param contactNo
 * @param school
 * @param branch
 * @param course
 * @param skills
 * @param fow or field_of_work
 * @param resume
 * @param id - id of the applicant
 * 
 * this @return void
 */
function updateApplicant(
    $conn,
    $name,
    $status,
    $email,
    $contactNo,
    $school,
    $branch,
    $course,
    $skills,
    $fow,
    $resume,
    $id
) {
    $stmt = mysqli_stmt_init($conn);
    $query = "UPDATE application_portal SET name = ?, status = ?, email = ?, contact_no = ?, school = ?, branch = ?, course = ?, skills = ?, field_of_work = ?, resume = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param(
        $stmt,
        "sssssssssss",
        $name,
        $status,
        $email,
        $contactNo,
        $school,
        $branch,
        $course,
        $skills,
        $fow,
        $resume,
        $id
    );
    mysqli_stmt_execute($stmt);
}

# update status applicant

// probation
/**
 * 
 * this updates the meeting schedule of the applicant
 * and sets their status to probation
 * receives the params
 * 
 * @param conn - for database connection
 * @param status
 * @param id - id of the applicant
 * @param dateTimeString - the date and time concatenated string
 * 
 * this @return void
 */
function setToProbation($conn, $id, $dateTimeString)
{
    $query = "UPDATE application_portal SET status = 'Probation', meeting_sched = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $dateTimeString, $id);
    mysqli_stmt_execute($stmt);
}

// white listed
/**
 * 
 * this updates the status to waitlisted
 * receives the params
 * 
 * @param conn - for database connection
 * @param id - id of the applicant
 * 
 * this @return void
 */
function setToWaitListed($conn, $id)
{
    $query = "UPDATE application_portal SET status = 'Waitlisted' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
}

//withdrawn
/**
 * 
 * this updates the status to withdrawn
 * receives the params
 * 
 * @param conn - for database connection
 * @param id - id of the applicant
 * 
 * this @return void
 */
function setToWithdrawn($conn, $id)
{
    $query = "UPDATE application_portal SET status = 'Withdrawn' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
}

// orientation
/**
 * 
 * this updates the meeting schedule of the applicant
 * and sets their status to orientation
 * receives the params
 * 
 * @param conn - for database connection
 * @param status
 * @param id - id of the applicant
 * @param dateTimeString - the date and time concatenated string
 * 
 * this @return void
 */
function setToOrientation($conn, $id, $dateTimeString)
{
    $query = "UPDATE application_portal SET status = 'Orientation', meeting_sched = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $dateTimeString, $id);
    mysqli_stmt_execute($stmt);
}

// Follow-Up
/**
 * 
 * this updates the meeting schedule of the applicant
 * and sets their status to follow-up
 * receives the params
 * 
 * @param conn - for database connection
 * @param status
 * @param id - id of the applicant
 * @param dateTimeString - the date and time concatenated string
 * 
 * this @return void
 */
function remindApplicant($conn, $id, $dateTimeString)
{
    $query = "UPDATE application_portal SET status = 'Follow-up', meeting_sched = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $dateTimeString, $id);
    mysqli_stmt_execute($stmt);
}


# delete applicant
/**
 * 
 * deletes the applicant based on their id
 * receives 2 params
 * @param conn - for the database connection
 * @param id - if of the applicant
 * 
 * @return void
 */
function deleteApplicant($conn, $id)
{
    $query = "DELETE FROM application_portal WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
}

/**
 *
 * fetches the number of rows depends on the tableName
 * receives 2 params
 * @param conn - for database connection
 * @param tableName - table name
 * 
 * @return num_rows - the count of all rows
 */
function fetchNumRows($conn, $tableName)
{
    $query = "SELECT COUNT(id) FROM " . $tableName;
    $result = mysqli_query($conn, $query);
    $numRows = mysqli_fetch_assoc($result);
    return $numRows["COUNT(id)"];
}

/**
 * 
 * fetch the paginated results and its ordered by each column name in ascending order 
 * receives 5 params
 * 
 * @param conn - database connection
 * @param tableName
 * @param resultPerPage - the results per page
 * @param offset - the offset of the page
 * @param colName - url params column name
 * 
 * @return paginatedResult
 */
function fetchPaginatedResult($conn, $tableName, $resultsPerPage, $offset, $colName)
{
    $query = "SELECT * FROM " . $tableName . " ORDER BY " . $colName . " ASC LIMIT " . $resultsPerPage . " OFFSET " . $offset;
    $paginatedResult = mysqli_query($conn, $query);
    return $paginatedResult;
}

/**
 * 
 * fetch the paginated results and its ordered by each column name in ascending order together with search query in the applicant panel
 * receives 6 params
 * 
 * @param conn - database connection
 * @param tableName
 * @param resultPerPage - the results per page
 * @param offset - the offset of the page
 * @param colName - url params column name
 * @param param - the search query url param
 * 
 * @return paginatedSearchResult
 */
function fetchPaginatedSearchResult($conn, $tableName, $resultsPerPage, $offset, $colName, $param)
{
    $param = "'%" . $param . "%'";
    $query =
        "SELECT * FROM " . $tableName .
        " WHERE CONCAT_WS(' ', name, email, status, school, branch, field_of_work) LIKE " . $param .
        " ORDER BY " . $colName . " ASC " .
        " LIMIT " . $resultsPerPage . " OFFSET " . $offset;
    $paginatedSearchResult = mysqli_query($conn, $query);
    return $paginatedSearchResult;
}

/**
 * 
 * fetch the paginated results and its ordered by each column name in ascending order together with the search query in the admin panel
 * receives 6 params
 * 
 * @param conn - database connection
 * @param tableName
 * @param resultPerPage - the results per page
 * @param offset - the offset of the page
 * @param colName - url params column name
 * @param param - the search query url param
 * 
 * @return paginatedResult
 */
function fetchPaginatedAdminsSearchResult($conn, $tableName, $resultsPerPage, $offset, $colName, $param)
{
    $param = "'%" . $param . "%'";
    $query =
        "SELECT * FROM " . $tableName .
        " WHERE CONCAT_WS(' ', username, role, name, email) LIKE " . $param .
        " ORDER BY " . $colName . " ASC " .
        " LIMIT " . $resultsPerPage . " OFFSET " . $offset;
    $paginatedSearchResult = mysqli_query($conn, $query);
    return $paginatedSearchResult;
}

// admin role

# add admin/moderator
/**
 * 
 * saves a new admin user into the database together with the date when the user is created
 * receives 6 params
 * 
 * @param conn
 * @param name
 * @param email
 * @param username
 * @param password
 * @param role
 * 
 * @return void
 */
function saveUser($conn, $name, $email, $username, $password, $role)
{
    $date = date("Y/m/d H:i:s");
    $password = hashPassword($password);
    $query = "INSERT INTO application_portal_admin (name, email, username, password, role, created_at) VALUES (?,?,?,?,?,?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssss", $name, $email, $username, $password, $role, $date);
    mysqli_stmt_execute($stmt);
}

# update moderator/admin
/**
 * 
 * updates the admin based on their id 
 * receives 6 params
 * 
 * @param conn
 * @param name
 * @param email
 * @param username
 * @param role
 * @param id
 * 
 * @return void
 */
function updateUser($conn, $name, $email, $username, $role, $id)
{
    $query = "UPDATE application_portal_admin SET name = ?, email = ?, username = ?, role = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $username, $role, $id);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);
}

# delete admin/moderator
/**
 * 
 * deletes the user based on their id
 * 
 * @param conn
 * @param id
 * 
 * @return void
 */
function deleteUser($conn, $id)
{
    $query = "DELETE FROM application_portal_admin WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
}

# fetch all admin/moderator
/**
 * 
 * fetches all the users or admins/moderators from the database
 * 
 * @param conn
 * 
 * returns an associative array of users
 * @return rows
 */
function getUsers($conn)
{
    $query = "SELECT * FROM application_portal_admin ORDER BY created_at ASC";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $rows = mysqli_fetch_assoc($result);
    return $rows;
}

# fetch moderator by id
/**
 * 
 * fetches the user by id and return a row of the applicant's details
 * receives two params
 * 
 * @param conn
 * @param id
 * 
 * @return row
 */
function getUserById($conn, $id)
{
    $query = "SELECT * FROM application_portal_admin WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row;
}

// fetch and update the value in dashboard

/**
 * 
 * fetches the total count of applicant in the application_portal
 * 
 * @param conn
 * 
 * @return row - COUNT(id)
 */
function getApplicantsCount($conn)
{
    $query = "SELECT COUNT(id) FROM application_portal";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row["COUNT(id)"];
}

/**
 * 
 * fetches the total count of admin in the application_portal_admin
 * 
 * @param conn
 * 
 * @return row - COUNT(role)
 */
function getAdminsCount($conn)
{
    $query = "SELECT COUNT(role) FROM application_portal_admin WHERE role = 'admin'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row["COUNT(role)"];
}

/**
 * 
 * get the total count of moderator in the application_portal_admin
 * 
 * @param conn
 * 
 * @return row - COUNT(role)
 */
function getModCount($conn)
{
    $query = "SELECT COUNT(role) FROM application_portal_admin WHERE role = 'moderator'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row["COUNT(role)"];
}

/**
 * 
 * get the total count of applicant with the status of probation in the application_portal
 * 
 * @param conn
 * 
 * @return row - COUNT(status)
 */
function getProbationCount($conn)
{
    $query = "SELECT COUNT(status) FROM application_portal WHERE status = 'Probation'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row["COUNT(status)"];
}

/**
 * 
 * get the total count of applicant with the status of orientation in the application_portal
 * 
 * @param conn
 * 
 * @return row - COUNT(status)
 */
function getPreScreeningCount($conn)
{
    $query = "SELECT COUNT(status) FROM application_portal WHERE status = 'Pre-screening'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row["COUNT(status)"];
}

/**
 * 
 * get the total count of applicant with the status of waitlisted in the application_portal
 * 
 * @param conn
 * 
 * @return row - COUNT(status)
 */
function getWaitlistedCount($conn)
{
    $query = "SELECT COUNT(status) FROM application_portal WHERE status = 'Waitlisted'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row["COUNT(status)"];
}
