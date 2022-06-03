<?php

function sanitizeInputs($conn, $input) {
    $input = trim($input);
    $input = mysqli_real_escape_string($conn, $input);
    return $input;
}

function closeAndFree($conn, $result) {
    mysqli_free_result($result);
    mysqli_close($conn);
}

//login functions
function hashPassword($password) {
    $SHA_512 = "$6$";
    $hashFormat = $SHA_512 . "rounds=5000";
    $salt = "sananamanpansininakonicrushuwu<3<3<3";
    $hash = $hashFormat . $salt;

    $password = crypt($password, $hash);

    return $password;
}

function verifyPassword($password, $dbPassword) {
    $SHA_512 = "$6$";
    $hashFormat = $SHA_512 . "rounds=5000";
    $salt = "sananamanpansininakonicrushuwu<3<3<3";
    $hash = $hashFormat . $salt;

    if(crypt($password, $hash) == $dbPassword) {
        return true;
    } else {
        return false;
    }
}

function login($conn, $username, $password) {
    $query = "SELECT username, password, role FROM application_portal_admin WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = mysqli_fetch_assoc($result);
    if (verifyPassword($password, $rows["password"])) {
        $numRow = mysqli_num_rows($result);
        if($numRow > 0) {
            closeAndFree($conn, $result);
            return true;
        } else {
            closeAndFree($conn, $result);
            return false;
        }
    } else {
        closeAndFree($conn, $result);
        return false;
    }
}

function authorizeUser($conn, $username, $password, $role) {
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

function getApplicantById($conn, $id) {
    $query = "SELECT * FROM application_portal WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    closeAndFree($conn, $result);
    return $row;
}

# update status applicant

// probation
function setToProbation($conn) {
    $query = "UPDATE application_portal SET status = 'probation'";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);
}

// white listed
function setToWhiteListed($conn) {
    $query = "UPDATE application_portal SET status = 'white_listed'";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);
}

# delete applicant
function deleteApplicant($conn, $id) {
    $query = "DELETE FROM application_portal WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);
}

# accept applicant (delete applicant)

# reject applicant (delete applicant)

// admin role

# add admin/moderator
function saveUser($conn, $name, $email, $username, $password, $role) {
    $date = date("Y/m/d H:i:s");
    $password = hashPassword($password);
    $query = "INSERT INTO application_portal_admin (name, email, username, password, role, created_at) VALUES (?,?,?,?,?,?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssss", $name, $email, $username, $password, $role, $date);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);
}

# update moderator/admin
function updateUser($conn, $name, $email, $username, $role) {
    $password = hashPassword($password);
    $query = "UPDATE application_portal_admin SET name = ?, email = ?, username = ?, role = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $username, $password, $role);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);
}

# delete admin/moderator
function deleteUser($conn, $id) {
    $query = "DELETE FROM application_portal_admin WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);
}

# fetch all admin/moderator
function getUsers($conn) {
    $query = "SELECT * FROM application_portal_admin ORDER BY created_at ASC";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $rows = mysqli_fetch_assoc($result);
    closeAndFree($conn, $result);
    return $rows;
}

# fetch moderator by id
function getUserById($conn, $id) {
    $query = "SELECT * FROM application_portal_admin WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    closeAndFree($conn, $result);
    return $row;
}

// require "../../includes/db.php";
// // name, email, username, password, role
// saveUser($conn, "James Read", "jamesread@gmail.com", "admin", "123456", "admin");