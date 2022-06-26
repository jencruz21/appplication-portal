<?php

function sanitizeInputs($conn, $input)
{
    $input = trim($input);
    $input = mysqli_real_escape_string($conn, $input);
    return $input;
}

//login functions
function hashPassword($password)
{
    $SHA_512 = "$6$";
    $hashFormat = $SHA_512 . "rounds=5000";
    $salt = "sananamanpansininakonicrushuwu<3<3<3";
    $hash = $hashFormat . $salt;

    $password = crypt($password, $hash);

    return $password;
}

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
function setToProbation($conn, $id, $dateTimeString)
{
    $query = "UPDATE application_portal SET status = 'Probation', meeting_sched = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $dateTimeString, $id);
    mysqli_stmt_execute($stmt);
}

// white listed
function setToWaitListed($conn, $id)
{
    $query = "UPDATE application_portal SET status = 'Waitlisted' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
}

//withdrawn
function setToWithdrawn($conn, $id)
{
    $query = "UPDATE application_portal SET status = 'Withdrawn' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
}

// orientation
function setToOrientation($conn, $id, $dateTimeString)
{
    $query = "UPDATE application_portal SET status = 'Orientation', meeting_sched = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $dateTimeString, $id);
    mysqli_stmt_execute($stmt);
}

# delete applicant
function deleteApplicant($conn, $id)
{
    $query = "DELETE FROM application_portal WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
}

// storing scheduled meeting

// function saveSchedule($conn, $schedule, $id)
// {
//     $query = "UPDATE application_portal SET meeting_sched = ? WHERE id = ?";
//     $stmt = mysqli_prepare($conn, $query);
//     mysqli_stmt_bind_param($stmt, "ss", $schedule, $id);
//     mysqli_stmt_execute($stmt);
// }

function fetchNumRows($conn, $tableName)
{
    $query = "SELECT COUNT(id) FROM " . $tableName;
    $result = mysqli_query($conn, $query);
    $numRows = mysqli_fetch_assoc($result);
    return $numRows["COUNT(id)"];
}

// fetch the paginated results and its ordered by each column name in ascending order
function fetchPaginatedResult($conn, $tableName, $resultsPerPage, $offset, $colName)
{
    $query = "SELECT * FROM " . $tableName . " ORDER BY " . $colName . " ASC LIMIT " . $resultsPerPage . " OFFSET " . $offset;
    $paginatedResult = mysqli_query($conn, $query);
    return $paginatedResult;
}

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
function updateUser($conn, $name, $email, $username, $role, $id)
{
    $query = "UPDATE application_portal_admin SET name = ?, email = ?, username = ?, role = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $username, $role, $id);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);
}

# delete admin/moderator
function deleteUser($conn, $id)
{
    $query = "DELETE FROM application_portal_admin WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
}

# fetch all admin/moderator
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

// fetch data from people_count
function getPeopleCount($conn)
{
    $query = "SELECT * FROM people_count WHERE id = 1";
    $result = mysqli_query($conn, $query);
    $result = mysqli_fetch_assoc($result);
    return $result;
}

// applicants update
function getApplicantsCount($conn) {
    $query = "SELECT COUNT(id) FROM application_portal";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row["COUNT(id)"];
}

// admins update
function getAdminsCount($conn)
{
    $query = "SELECT COUNT(role) FROM application_portal_admin WHERE role = 'admin'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row["COUNT(role)"];
}

// moderator update
function getModCount($conn)
{
    $query = "SELECT COUNT(role) FROM application_portal_admin WHERE role = 'moderator'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row["COUNT(role)"];
}

// probation update
function getProbationCount($conn)
{
    $query = "SELECT COUNT(role) FROM application_portal_admin WHERE role = 'Probation'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row["COUNT(role)"];
}

// orientation update
function updateOrientationCount($conn)
{
    $query = "SELECT COUNT(role) FROM application_portal_admin WHERE role = 'Orientation'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row["COUNT(role)"];
}

// waitlisted update
function updateWaitlistedCount($conn)
{
    $query = "SELECT COUNT(role) FROM application_portal_admin WHERE role = 'Waitlisted'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row["COUNT(role)"];
}

// require "../../includes/db.php";
// // name, email, username, password, role
// saveUser($conn, "James Read", "jamesread@gmail.com", "admin", "123456", "admin");