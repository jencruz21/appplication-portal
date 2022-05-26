<?php

    function sanitizeData($conn, $data) {
        $data = trim($data);
        $data = mysqli_real_escape_string($conn, $data);
        return $data;
    }

    // prepared statements
    function saveFormData(
                        $conn,
                        $name,
                        $status,
                        $email,
                        $contactNo,
                        $school,
                        $branch,
                        $course,
                        $gdrive_link,
                        $skills,
                        $created_at
                        ) 
    {
        $stmt = mysqli_stmt_init($conn);
        $query = "INSERT INTO application_portal (
            name, 
            status, 
            email, 
            contact_no, 
            school, 
            branch, 
            course, 
            gdrive_link, 
            skills, 
            created_at) 
            VALUES (?,?,?,?,?,?,?,?,?,?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssssssss", 
            $name, 
            $status, 
            $email, 
            $contactNo, 
            $school, 
            $branch, 
            $course, 
            $gdrive_link, 
            $skills,
            $created_at);
        mysqli_stmt_execute($stmt);
        mysqli_close($conn);
    }

    function isFieldsEmpty($name, $email, $contact_no, $school, $branch, $course, $skills) {
        if (empty($name) || 
        empty($email) || 
        empty($contact_no) || 
        empty($school) || 
        empty($branch) || 
        empty($course) || 
        empty($skills)) {
            return true;
        } else {
            return false;
        }   
    }